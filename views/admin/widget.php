<?php

/* @var $this \humhub\modules\ui\view\components\View */
/* @var $model \gm\humhub\integration\discord\models\ConfigureForm */

use humhub\modules\ui\form\widgets\SortOrderField;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Yii::t('DiscordModule.widget', '<strong>Discord</strong> widgets configuration') ?></div>

        <div class="panel-body">

            <?php $form = ActiveForm::begin(['id' => 'configure-form']); ?>

            <div class="form-group">
                <?= $form->field($model, 'serverUrl'); ?>
                <?= $form->field($model, 'sortOrder')->widget(SortOrderField::class) ?>
            </div>
            <br/>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('DiscordModule.base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
                <?= Html::a(Yii::t('DiscordModule.widget', 'Back'), [Url::to('/discord/admin/index')], ['class'=>'btn btn-primary', 'data-ui-loader' => '']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
