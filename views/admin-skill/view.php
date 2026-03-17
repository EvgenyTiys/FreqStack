<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\tables\Skill $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Skills', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$indexUrl = Url::to(['index']);
$indexUrlJs = Json::htmlEncode($indexUrl);
$this->registerJs(<<<JS
document.addEventListener('keydown', function (e) {
  if (e.isComposing) return;
  if (e.key !== 'Enter') return;
  if (e.ctrlKey || e.metaKey || e.altKey || e.shiftKey) return;

  var t = e.target;
  var tag = (t && t.tagName) ? String(t.tagName).toUpperCase() : '';
  if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT' || tag === 'BUTTON' || tag === 'A') return;

  e.preventDefault();
  window.location.href = $indexUrlJs;
});
JS);
?>
<div class="skill-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'SkillCathegory_id',
            'name',
            'count',
        ],
    ]) ?>

</div>
