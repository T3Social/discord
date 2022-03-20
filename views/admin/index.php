<?php

/* @var $this \humhub\modules\ui\view\components\View */
/* @var $model \gm\humhub\integration\discord\models\ConfigureForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Yii::t('DiscordModule.base', '<strong>Discord</strong> Sign-In configuration') ?></div>

        <div class="panel-body">
            <p>
                <?= Html::a(Yii::t('DiscordModule.base', 'Discord Documentation'), 'https://discord.com/developers/docs/intro', ['class' => 'btn btn-primary pull-right btn-sm', 'target' => '_blank']); ?>
                <?= Yii::t('DiscordModule.base', 'Please follow the Discord instructions to create the required <strong>OAuth client</strong> credentials.'); ?>
                <br/>
            </p>
            <br/>

            <?php $form = ActiveForm::begin(['id' => 'configure-form', 'enableClientValidation' => false, 'enableClientScript' => false]); ?>

            <?= $form->field($model, 'enabled')->checkbox(); ?>
            <?= $form->field($model, 'autoLogin')->checkbox(); ?>

            <br/>
            <?= $form->field($model, 'clientId'); ?>
            <?= $form->field($model, 'clientSecret')->textInput(['type' => 'password']); ?>
            <?= $form->field($model, 'webhook')->textInput(['placeholder' => Yii::t('DiscordModule.base', 'Currently Disabled'), 'readonly' => true]); ?>

            <br/>
            <?= $form->field($model, 'redirectUri')->textInput(['readonly' => true]); ?>
            <br/>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('DiscordModule.base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
                <?= Html::a('Widget', [Url::to('/discord/admin/widget')], ['class'=>'btn btn-primary', 'data-ui-loader' => '']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
