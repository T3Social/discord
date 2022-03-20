<?php

namespace gm\humhub\modules\integration\discord\controllers;

use Yii;
use humhub\components\access\ControllerAccess;
use humhub\modules\content\components\ContentContainerControllerAccess;
use gm\humhub\modules\integration\discord\models\SpaceForm;
use humhub\modules\content\components\ContentContainerController;

class SpaceAdminController extends ContentContainerController
{
    public function actionIndex()
    {
        $model = new SpaceForm(['contentContainer' => $this->contentContainer]);
        $model->loadSettings();
        if ($model->load(Yii::$app->request->post()) && $model->saveSettings()) {
            $this->view->saved();
        }
        return $this->render('index', ['model' => $model]);
    }

    protected function getPageClassName()
    {
        return $this->contentContainer(SpaceForm::class);
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        if ($this->contentContainer) {
            return [
                [ContentContainerControllerAccess::RULE_USER_GROUP_ONLY => [Space::USERGROUP_ADMIN]],
            ];
        }

        return [
            [ControllerAccess::RULE_ADMIN_ONLY]
        ];
    }
}