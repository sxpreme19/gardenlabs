<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Userprofile;

/** @var yii\web\View $this */
/** @var common\models\Servico $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'preco')->textInput(['type' => 'number', 'step' => '0.01', 'min' => '0.01']) ?>

        <?= $form->field($model, 'duracao')->textInput(['type' => 'number', 'step' => '1', 'min' => '1']) ?>

        <?= $form->field($model, 'prestador_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(
                Userprofile::find()
                    ->join('LEFT JOIN', 'user', 'userprofile.user_id = user.id')
                    ->join('LEFT JOIN', 'auth_assignment', 'user.id = auth_assignment.user_id')
                    ->where(['auth_assignment.item_name' => 'provider'])
                    ->all(),
                'id',
                'nome'
            ),
            ['prompt' => 'Select a Provider']
        ) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>