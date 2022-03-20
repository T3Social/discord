<?php

namespace gm\humhub\modules\integration\discord\controllers;

use Yii;
use humhub\modules\admin\components\Controller;
use gm\humhub\modules\integration\discord\models\ConfigureForm;

/**
 * Module configuation
 */
class AdminController extends Controller
{

    public function actionIndex()
    {
        $model = new ConfigureForm();
        $model->loadSettings();

        if ($model->load(Yii::$app->request->post()) && $model->saveSettings()) {
            $this->view->saved();
        }

        return $this->render('index', ['model' => $model]);
    }

    /**
     * Render admin only page
     *
     * @return string
     */
    public function actionWidget()
    {
        $model = ConfigureForm::getInstance();
        $model->loadSettings();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->saveSettings()) {
            $this->view->saved();
        }

        return $this->render('widget', ['model' => $model]);
    }
}
