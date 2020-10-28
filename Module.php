<?php

namespace gm\humhub\modules\auth\discord;

use yii\helpers\Url;
use humhub\components\Module as BaseModule;
/**
 * @inheritdoc
 */
class Module extends BaseModule
{

    /**
     * @inheritdoc
     */
    public $resourcesPath = 'resources';

    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to(['/auth-discord/admin']);
    }

    /**
     * @inheritdoc
     */
    public function disable()
    {
        // Cleanup all module data, don't remove the parent::disable()!!!
        parent::disable();
    }
}
