<?php

namespace gm\humhub\modules\integration\discord\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use gm\humhub\modules\integration\discord\Module;
use humhub\modules\content\models\ContentContainer;
use humhub\modules\content\components\ContentContainerActiveRecord;

/**
 * The module configuration model
 */
class ConfigureForm extends Model
{

    /**
     * @var boolean Enable this authclient
     */
    public $enabled;

    /**
     * @var string the client id provided by Discord
     */
    public $clientId;

    /**
     * @var string the client secret provided by Discord
     */
    public $clientSecret;

    /**
     * @var string readonly
     */
    public $redirectUri;

    /**
     * @var bool
     */
    public $autoLogin = false;

    /**
     * @var string the client secret provided by Discord
     */
    public $webhook;

    /**
     * Sort the order of the widget
     */
    public $sortOrder;

    /**
     * @inheritdoc
     */
    public $moduleId = 'discord';

    public $serverUrl;

    public function afterFind()
    {
        $this->updateState();
        parent::afterFind();
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'discord';
    }

    public function canView()
    {
        if ($this->admin_only && !$this->canSeeAdminOnlyContent()) {
            return false;
        }

        // Todo: Workaround for bug present prior to HumHub v1.3.18
        if (Yii::$app->user->isGuest && !$this->content->container && $this->content->isPublic()) {
            return true;
        }

        // Todo: Workaround for global content visibility bug present prior to HumHub v1.5
        if (empty($this->content->contentcontainer_id) && !Yii::$app->user->isGuest) {
            return true;
        }

        return $this->content->canView();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clientId', 'clientSecret'], 'required'],
            [['serverUrl'], 'required'],
            [['sortOrder'], 'integer'],
            [['enabled', 'autoLogin'], 'boolean'],
            [['webhook'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'enabled' => Yii::t('DiscordModule.base', 'Enabled'),
            'clientId' => Yii::t('DiscordModule.base', 'Client ID'),
            'clientSecret' => Yii::t('DiscordModule.base', 'Client secret'),
            'autoLogin' => Yii::t('DiscordModule.base', 'Automatic Login'),
            'webhook' => Yii::t('DiscordModule.base', 'Webhook'),
            'serverUrl' => 'Discord Widget URL:',
            'sortOrder' => 'Sort sidebar order',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'autoLogin' => Yii::t('DiscordModule.base', 'Possible only if anonymous registration is allowed in the admin users settings'),
            'serverUrl' => 'e.g. https://discord.com/widget?id={server-id} or https://discord.com/widget?id={server-id}&theme=dark',
        ];
    }

    /**
     * Static initializer
     * @return \self
     */
    public static function instantiate()
    {
        return new self;
    }

    /**
     * Loads the current module settings
     */
    public function loadSettings()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('discord');

        $this->enabled = (boolean)$module->settings->get('enabled');
        $this->clientId = $module->settings->get('clientId');
        $this->clientSecret = $module->settings->get('clientSecret');
        $this->webhook = $module->settings->get('webhook', $this->webhook);
        $this->autoLogin = (boolean)$module->settings->get('autoLogin', $this->autoLogin);
        $this->serverUrl = $module->settings->get('serverUrl');

        $this->redirectUri = Url::to(['/user/auth/external', 'authclient' => 'discord'], true);
    }

    /**
     * Saves module settings
     */
    public function saveSettings()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('discord');

        $module->settings->set('sortOrder', $this->sortOrder);
        $module->settings->set('serverUrl', $this->serverUrl);
        $module->settings->set('enabled', (boolean)$this->enabled);
        $module->settings->set('clientId', $this->clientId);
        $module->settings->set('clientSecret', $this->clientSecret);
        $module->settings->set('webhook', $this->webhook);

        return true;
    }

    /**
     * Deletes all tags by module id
     * @param ContentContainerActiveRecord|int $contentContainer
     */
    public static function deleteByModule($contentContainer = null)
    {
        $instance = new static();

        if ($contentContainer) {
            $container_id = $contentContainer instanceof ContentContainerActiveRecord ? $contentContainer->contentcontainer_id : $contentContainer;
            static::deleteAll(['module_id' => $instance->module_id, 'contentcontainer_id' => $container_id]);
        } else {
            static::deleteAll(['module_id' => $instance->module_id]);
        }
    }

    /**
     * Deletes all tags by type
     * @param ContentContainerActiveRecord|int $contentContainer
     */
    public static function deleteByType($contentContainer = null)
    {
        $instance = new static();

        if($contentContainer) {
            $container_id = $contentContainer instanceof ContentContainerActiveRecord ? $contentContainer->contentcontainer_id : $contentContainer;
            static::deleteAll(['type' => $instance->type, 'contentcontainer_id' => $container_id]);
        } else {
            static::deleteAll(['type' => $instance->type]);
        }
    }

    /**
     * Returns a loaded instance of this configuration model
     */
    public static function getInstance()
    {
        $config = new static;
        $config->loadSettings();

        return $config;
    }

}
