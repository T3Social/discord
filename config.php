<?php

use humhub\modules\user\authclient\Collection;
use humhub\widgets\BaseMenu;
use gm\humhub\modules\integration\discord\Events;
use gm\humhub\modules\integration\discord\Module;
use humhub\modules\space\widgets\Sidebar as Space;
use humhub\modules\space\widgets\HeaderControlsMenu;
use humhub\modules\dashboard\widgets\Sidebar as Dashboard;

return [
    'id' => 'discord',
    'class' => Module::class,
    'namespace' => 'gm\humhub\modules\integration\discord',
    'events' => [
        [Collection::class, Collection::EVENT_AFTER_CLIENTS_SET, [Events::class, 'onAuthClientCollectionInit']],
        ['class' => Dashboard::class, 'event' => Dashboard::EVENT_INIT, 'callback' => [Events::class, 'addDiscordFrame']],
        ['class' => Space::class, 'event' => Space::EVENT_INIT, 'callback' => [Events::class, 'onSpaceSidebarInit']],
        ['class' => HeaderControlsMenu::class, 'event' => BaseMenu::EVENT_INIT, 'callback' => [Events::class, 'onSpaceAdminMenuInit']],
    ],
];
