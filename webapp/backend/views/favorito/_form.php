<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Favorito $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'userprofile_id')->textInput(['type' => 'number', 'step' => '1','min' => '1']) ?>

        <?= $form->field($model, 'servico_id')->textInput(['type' => 'number', 'step' => '1','min' => '1']) ?>

        <?= $form->field($model, 'produto_id')->textInput(['type' => 'number', 'step' => '1','min' => '1']) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>