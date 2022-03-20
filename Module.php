<?php

namespace gm\humhub\modules\integration\discord;

use Yii;
use yii\helpers\Url;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\components\ContentContainerModule;
use humhub\modules\content\components\ContentActiveRecord;
use gm\humhub\modules\integration\discord\models\ConfigureForm;
use gm\humhub\modules\integration\discord\models\SpaceForm;
use humhub\modules\space\models\Space;

/**
 * @inheritdoc
 */
class Module extends ContentContainerModule
{

    /**
     * @inheritdoc
     */
    public $resourcesPath = 'resources';

    /**
    * @inheritdoc
    */
    public function getContentContainerTypes()
    {
        return [
            Space::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to(['/discord/admin']);
    }

    /**
     * @inheritdoc
     */
    public function disable()
    {
        parent::disable();
    }


    /**
     * @inheritdoc
     * @throws \yii\base\Exception
     * @throws \Throwable
     */
    public function disableContentContainer(ContentContainerActiveRecord $container)
    {

        parent::disableContentContainer($container);
    }

    /**
    * @inheritdoc
    */
    public function getContentContainerName(ContentContainerActiveRecord $container)
    {
        return Yii::t('DiscordModule.widget', 'Discord Widget');
    }

    /**
    * @inheritdoc
    */
    public function getContentContainerDescription(ContentContainerActiveRecord $container)
    {
        return Yii::t('DiscordModule.widget', 'Adds the offical Discord widget to your HumHub instance sidebar on the Dashboard/Space.');
    }

    public function getServerUrl()
    {
        $url = $this->settings->get('serverUrl');
        if (empty($url)) {
            return 'https://discord.com';
        }
        return $url;
    }

    public function getSUrl()
    {
        $sUrl = $this->settings->space()->get('sUrl');
        if (empty($sUrl)) {
            return 'https://discord.com';
        }
        return $sUrl;
    }

    public function getOrder()
    {
        $sortOrder = $this->settings->get('sortOrder');
        if (empty($sortOrder)) {
            return '100';
        }
        return $sortOrder;
    }
}
