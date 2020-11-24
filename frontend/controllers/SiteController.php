<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\Category;
use common\models\Gallery;
use common\models\ImageUpload;
use Imagine\Image\Box;
use Yii;
use yii\imagine\Image;
use yii\base\DynamicModel;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\Response;
use yii\web\UploadedFile;
use common\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [

                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $categories = Category::find()->all();

        $galleries = Gallery::getGalleries();
        shuffle($galleries);

        $data = Article::getRecent(9);

        return $this->render(
            'index',
            [
                'recent' => $data,
                'galleries' => $galleries,
                'categories' => $categories
            ]
        );
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if (yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->renderAjax('modal_template', ['model' => $model]);
            } else {
                $model->password = '';
                return $this->renderAjax('login', ['model' => $model]);
            }
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('/');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if (yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $user = $model->signup()) {
                    Yii::$app->getUser()->login($user);
                    return $this->renderAjax('modal_template', ['model' => $model]);
                } else {
                    $model->password = '';
                    return $this->renderAjax('signup', ['model' => $model]);
                }
            }
            return $this->renderAjax('signup', ['model' => $model]);
        }
    }

    public function actionPersonal()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = User::findOne(yii::$app->user->id);


        if ($user->load(Yii::$app->request->post())) {
            if ($user->save()) {
            } else {
                return $this->render(
                    'personal',
                    [
                        'user' => $user,
                        'popular_articles' => Article::getPopular(),
                        'categories' => Article::getCategories(),
                    ]
                );
            }
        }

        return $this->render(
            'personal',
            [
                'user' => $user,
                'popular_articles' => Article::getPopular(),
                'months' => Article::getArchive(),
                'categories' => Article::getCategories(),
            ]
        );
    }

    public function actionSetImage()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }

        $id = Yii::$app->user->id;

        $user = User::findOne($id);
        $model = new ImageUpload();
        if ($user->image) {
            $model->image = Yii::getAlias('@backendBaseUrl') . '/elfinder/users/user_' . $id . '/' . $user->image;
        }
        $path_to_folder = Yii::getAlias('@backend') . '/web/elfinder/users/user_' . $id;

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

            $saveOptions = ['jpeg_quality' => 100, 'png_compression_level' => 1];

            if (!is_dir($path_to_folder)) {
                mkdir($path_to_folder);
            }
            $imageName = 'user-logo.jpg';

            if ($image->save($path_to_folder . '/' . $imageName, $saveOptions)) {
                $date = date_create();
                $result = [
                    'filelink' => Yii::getAlias(
                            '@backendBaseUrl'
                        ) . '/elfinder/users/user_' . $id . '/' . $imageName . '?' . date_timestamp_get(
                            $date
                        )
                ];
                $user->saveImage($imageName);
            } else {
                $result = [
                    'error' => Yii::t('cropper', 'ERROR_CAN_NOT_UPLOAD_FILE')
                ];
            }
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $result;
        }

        return $this->render('image', ['model' => $model]);
    }

    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->sendEmail('adrej997@gmail.com');
//           todo change email for organization email
            Yii::$app->session->setFlash('success', "Ваше сообщение успешно отправлено");
            if (Yii::$app->request->get('action') == 'index') {
                return $this->goHome();
            } else {
                return $this->render('contact');
            }
        } else {
            return $this->render('contact', ['model' => $model]);
        }

        return $this->render('contact', ['model' => $model]);
    }


}
