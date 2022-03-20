<?php

namespace gm\humhub\modules\integration\discord\widgets;

use Yii;
use yii\base\Widget;
use gm\humhub\modules\integration\discord\models\SpaceForm;

/**
 *
 * @author Felli
 */
class SpaceFrame extends Widget
{
    /**
     * ContentContainer to limit tasks to. (Optional)
     *
     * @var ContentContainerActiveRecord
     */
    public $contentContainer;

    /**
     * How many snippets should be shown?
     *
     * @var int
     */
    public $limit = 1;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $settings = SpaceForm::instantiate();

        $sUrl = Yii::$app->getModule('discord')->getSUrl() . '/widget?id=';

        if (!$sUrl) {
            return '';
        }

        return $this->render('spaceframe', ['sUrl' => $sUrl]);
    }
}