<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

Yii::setAlias('@backendBaseUrl', 'http://localhost:21080');
Yii::setAlias('@frontendBaseUrl', 'http://localhost:20080');
Yii::setAlias('@phpmyadmin', 'http://localhost:8080');
