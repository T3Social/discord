<?php

use humhub\modules\user\authclient\Collection;

return [
    'id' => 'auth-discord',
    'class' => 'gm\humhub\modules\auth\discord\Module',
    'namespace' => 'gm\humhub\modules\auth\discord',
    'events' => [
        [Collection::class, Collection::EVENT_AFTER_CLIENTS_SET, ['gm\humhub\modules\auth\discord\Events', 'onAuthClientCollectionInit']]
    ],
];
