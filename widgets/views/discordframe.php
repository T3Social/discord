<?php

/* @var $this \humhub\modules\ui\view\components\View */

use humhub\libs\Html;
use humhub\widgets\PanelMenu;

?>

<div class="panel panel-default panel-discord" id="panel-discord">
    <?= PanelMenu::widget(['id' => 'panel-discord']); ?>
  <div class="panel-heading">
    <?= Yii::t('DiscordModule.widget', '<strong>Discord</strong> Chat'); ?>
  </div>
  <div class="panel-body">

<?= Html::beginTag('div') ?>
<iframe src="<?= $discordUrl; ?>" id="discordFrame" width="100%" height="500" allowtransparency="true" frameborder="0" name="iframeContainer"></iframe>
<?= Html::endTag('div'); ?>
</div>
</div>