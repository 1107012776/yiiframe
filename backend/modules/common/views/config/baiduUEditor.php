<?php

use common\helpers\Html;
use common\enums\StatusEnum;

?>

<div class="form-group">
    <?= Html::label(\Yii::t('app',$row['title']), $row['name'], ['class' => 'control-label demo']); ?>
    <?php if ($row['is_hide_remark'] != StatusEnum::ENABLED) { ?>
        <small><?= \yii\helpers\HtmlPurifier::process(\Yii::t('app',$row['remark'])) ?></small>
    <?php } ?>
    <?php
    if (\common\helpers\AddonHelper::isInstall('Ueditor'))
        echo \addons\Ueditor\common\widgets\ueditor\UEditor::widget([
            'id' => "config[" . $row['name'] . "]",
            'attribute' => $row['name'],
            'name' => "config[" . $row['name'] . "]",
            'value' => $row['value']['data'] ?? $row['default_value'],
        ]) ;
        else echo Html::textarea('config[' . $row['name'] . ']', $row['value']['data'] ?? $row['default_value'],
            ['class' => 'form-control','rows'=>10]);
    ?>
</div>