<?php

namespace backend\controllers;

use common\models\Article;
use common\models\Category;
use common\models\Functions;
use common\models\ImageUpload;
use Yii;
use common\models\Gallery;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


use yii\base\DynamicModel;
use yii\web\Response;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * GalleryController implements the CRUD actions for Gallery model.
 */
class GalleryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Gallery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => Gallery::find(),
            ]
        );

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Displays a single Gallery model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $path_to_Cropped_image = Yii::getAlias(
                '@backend'
            ) . '/web/elfinder/global/gallery/' . $model->dir_name . '/main/main-cropped.jpg';
        $path_to_art_dir = Yii::getAlias('@backend') . '/web/elfinder/global/gallery/' . $model->dir_name . '/main/';
        if (isset($_GET['saveImage']) && $_GET['saveImage'] == 1) {
            if (file_exists($path_to_Cropped_image)) {
                rename(
                    $path_to_Cropped_image,
                    $path_to_art_dir . 'main.jpg'
                );
            }
        } elseif (file_exists($path_to_Cropped_image)) {
            unlink($path_to_Cropped_image);
        }

        return $this->render(
            'view',
            [
                'model' => $model,
            ]
        );
    }

    public function actionSetImage()
    {
        $id = Yii::$app->request->get('id');

        $gallery = $this->findModel($id);
        $model = new ImageUpload();

        $path_to_folder = Yii::getAlias('@backend') . '/web/elfinder/global/gallery/' . $gallery->dir_name . '/main/';

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $file = UploadedFile::getInstanceByName('file');
            $model = new DynamicModel(compact('file'));
            $image = Image::crop(
                $file->tempName,
                intval($post['w']),
                intval($post['h']),
                [$post['x'], $post['y']]
            )->resize(
                new Box($post['width'], $post['height'])
            );
//            var_dump($image);die();

            $saveOptions = ['jpeg_quality' => 100, 'png_compression_level' => 1];

            if (!is_dir($path_to_folder)) {
                mkdir($path_to_folder);
            }
            $imageName = 'main-cropped.jpg';
            if ($image->save($path_to_folder . $imageName, $saveOptions)) {
                $date = date_create();
                $result = [
                    'filelink' => '/admin/elfinder/global/gallery/' . $gallery->dir_name . '/main/' . $imageName . '?' . date_timestamp_get(
                            $date
                        )
                ];
            } else {
                $result = [
                    'error' => Yii::t('cropper', 'ERROR_CAN_NOT_UPLOAD_FILE')
                ];
            }
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $result;
        }

        return $this->render('image', ['model' => $model, 'gallery_id' => $gallery->id]);
    }

    /**
     * Creates a new Gallery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Gallery();

        if ($model->load(Yii::$app->request->post())) {
            $model->images = UploadedFile::getInstances($model, 'images');

            $model->seo_url = Functions::getSeoUrl($model->title);
            $model->dir_name = $model->seo_url;
            $model->save(false);

            if (isset($model->images)) {
                $model->uploadImages();
            }


            if ($model->save()) {
//                $model->createFolder($model->dir_name);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Functions::pretty_var_dump($model->errors);
                die();
            }
        }

        return $this->render(
            'create',
            [
                'model' => $model,
                'categories' => Category::find()->all(),
                'articles' => Article::find()->all()

            ]
        );
    }

    /**
     * Updates an existing Gallery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->images = UploadedFile::getInstances($model, 'images');
            $model->seo_url = Functions::getSeoUrl($model->title);
            $model->save(false);

            if (isset($model->images)) {
                $model->uploadImages();
            }
            if ($model->save()) {
                $model->updateFolder($model->old_dir_name, $model->dir_name);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render(
            'update',
            [
                'model' => $model,
                'categories' => Category::find()->all(),
                'articles' => Article::find()->all()
            ]
        );
    }

    /**
     * Deletes an existing Gallery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $gallery = Gallery::findOne(['id' => $id]);

        $path_to_folder = Yii::getAlias('@backend') . '/web/elfinder/global/gallery/';

        Gallery::removeDirectory($path_to_folder . $gallery->dir_name);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Gallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gallery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionTest()
    {
        $gallery = new Gallery();
        return $this->render('test', ['model' => $gallery]);
    }
}
