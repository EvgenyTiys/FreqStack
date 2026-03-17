<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\tables\Skill $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array<int,string> $skillCathegoryList */
?>

<div class="skill-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'SkillCathegory_id')->dropDownList($skillCathegoryList, [
        'prompt' => '— выбери категорию —',
    ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'count')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
