<?php

namespace gm\humhub\modules\auth\discord;

use humhub\components\Event;
use humhub\modules\user\authclient\Collection;
use gm\humhub\modules\auth\discord\authclient\DiscordAuth;
use gm\humhub\modules\auth\discord\models\ConfigureForm;

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

}
