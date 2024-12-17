<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Carrinhoproduto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="carrinhoproduto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'userprofile_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
