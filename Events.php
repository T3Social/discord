<?php

namespace gm\humhub\modules\integration\discord;

use Yii;
use humhub\components\Event;
use humhub\modules\user\authclient\Collection;
use gm\humhub\modules\integration\discord\authclient\DiscordAuth;
use gm\humhub\modules\integration\discord\models\ConfigureForm;
use gm\humhub\modules\integration\discord\models\SpaceForm;
use humhub\modules\space\models\Space;

class Events
{
    /**
     * @param Event $event
     */
    public static function onAuthClientCollectionInit($event)
    {
        /** @var Collection $authClientCollection */
        $authClientCollection = $event->sender;

        if (!empty(ConfigureForm::getInstance()->enabled)) {
            $authClientCollection->setClient('discord', [
                'class' => DiscordAuth::class,
                'clientId' => ConfigureForm::getInstance()->clientId,
                'clientSecret' => ConfigureForm::getInstance()->clientSecret
            ]);
        }
    }

    public static function onSpaceAdminMenuInit($event)
    {
        /* @var $space \humhub\modules\space\models\Space */
        $space = $event->sender->space;

        if ($space->isModuleEnabled('discord') && $space->isAdmin() && $space->isMember()) {
            $settings = models\SpaceForm::instantiate();
            $event->sender->addItem([
                'label' => Yii::t('DiscordModule.base', 'Discord Settings'),
                'url' => $space->createUrl('/discord/space-admin/index'),
                'group' => 'admin',
                'icon' => '<i class="fab fa-discord"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'discord' && Yii::$app->controller->id == 'space-admin'),
                'sortOrder' => 650,
            ]);
        }
    }

    public static function onSpaceSidebarInit($event)
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        /* @var $space \humhub\modules\space\models\Space */
        $space = $event->sender->space;
        if ($space->isModuleEnabled('discord')) {
            $settings = models\SpaceForm::instantiate();
            $event->sender->addWidget(widgets\SpaceFrame::class, ['contentContainer' => $space]);
        }
    }

    public static function onSpaceMenuInit($event)
    {
        /* @var $space Space */
        $space = $event->sender->space;

        if ($space->isModuleEnabled('discord') && $space->isAdmin() && $space->isMember()) {
            $settings = models\SpaceForm::instantiate();
            $event->sender->addItem([
                'label' => 'Discord Settings',
                'url' => $space->createUrl('/discord/space-admin/index'),
                'group' => 'admin',
                'icon' => '<i class="fab fa-discord"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'discord' && Yii::$app->controller->id == 'space-admin'),
                'sortOrder' => 650,
            ]);
        }
    }

    public static function addDiscordFrame($event)
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        $module = Yii::$app->getModule('discord');

        $event->sender->addWidget(widgets\DiscordFrame::class, [], ['sortOrder' => $module->settings->get('sortOrder')]);
    }
}
