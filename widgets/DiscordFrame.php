<?php

namespace gm\humhub\modules\integration\discord\widgets;

use Yii;
use yii\base\Widget;

/**
 *
 * @author Felli
 */
class DiscordFrame extends Widget
{
    public $contentContainer;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $url = Yii::$app->getModule('discord')->getServerUrl() . '/widget?id=';

        if (!$url) {
            return '';
        }

        return $this->render('discordframe', ['discordUrl' => $url]);
    }

}