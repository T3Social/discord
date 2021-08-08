<?php

namespace gm\humhub\modules\auth\discord\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use gm\humhub\modules\auth\discord\Module;

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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clientId', 'clientSecret'], 'required'],
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
            'enabled' => Yii::t('AuthDiscordModule.base', 'Enabled'),
            'clientId' => Yii::t('AuthDiscordModule.base', 'Client ID'),
            'clientSecret' => Yii::t('AuthDiscordModule.base', 'Client secret'),
            'autoLogin' => Yii::t('AuthDiscordModule.base', 'Automatic Login'),
            'webhook' => Yii::t('AuthDiscordModule.base', 'Webhook'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'autoLogin' => Yii::t('AuthDiscordModule.base', 'Possible only if anonymous registration is allowed in the admin users settings'),
        ];
    }

    /**
     * Loads the current module settings
     */
    public function loadSettings()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('auth-discord');

        $settings = $module->settings;

        $this->enabled = (boolean)$settings->get('enabled');
        $this->clientId = $settings->get('clientId');
        $this->clientSecret = $settings->get('clientSecret');
        $this->webhook = $settings->get('webhook', $this->webhook);
        $this->autoLogin = (boolean)$settings->get('autoLogin', $this->autoLogin);

        $this->redirectUri = Url::to(['/user/auth/external', 'authclient' => 'discord'], true);
    }

    /**
     * Saves module settings
     */
    public function saveSettings()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('auth-discord');

        $module->settings->set('enabled', (boolean)$this->enabled);
        $module->settings->set('clientId', $this->clientId);
        $module->settings->set('clientSecret', $this->clientSecret);
        $module->settings->set('webhook', $this->webhook);

        return true;
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
