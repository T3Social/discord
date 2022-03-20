<?php

/* @var $this \humhub\modules\ui\view\components\View */
/* @var $model \gm\humhub\integration\discord\models\SpaceForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="panel panel-default">

    <div class="panel-heading"><?= Yii::t('DiscordModule.base', '<strong>Discord</strong> module configuration') ?></div>

    <div class="panel-body">

        <?php $form = ActiveForm::begin(['id' => 'space-form']); ?>
        <div class="form-group">
            <?= $form->field($model, 'sUrl'); ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('DiscordModule.base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>