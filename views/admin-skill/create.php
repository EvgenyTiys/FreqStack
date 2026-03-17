<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\tables\Skill $model */
/** @var array<int,string> $skillCathegoryList */

$this->title = 'Create Skill';
$this->params['breadcrumbs'][] = ['label' => 'Skills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'skillCathegoryList' => $skillCathegoryList,
    ]) ?>

</div>
