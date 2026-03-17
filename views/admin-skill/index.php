<?php

use app\models\tables\Skill;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var app\models\filters\SkillSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Skills';
$this->params['breadcrumbs'][] = $this->title;

YiiAsset::register($this);
?>
<div class="skill-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Skill', ['create'], ['class' => 'btn btn-success js-create-skill']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-bordered',
        ],
        'rowOptions' => static function (Skill $model) {
            $count = (int)($model->count ?? 0);
            if ($count <= 0) {
                $level = 0;
            } elseif ($count >= 5) {
                $level = 5;
            } else {
                $level = $count;
            }

            return [
                'class' => 'skill-row-level-' . $level,
            ];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute' => 'count',
                'format' => 'raw',
                'value' => static function (Skill $model) {
                    $count = (int)($model->count ?? 0);
                    $upUrl = Url::toRoute(['count-up', 'id' => $model->id]);
                    $downUrl = Url::toRoute(['count-down', 'id' => $model->id]);

                    $countSpan = Html::tag('span', (string)$count, [
                        'class' => 'js-skill-count',
                        'data-id' => (string)$model->id,
                    ]);

                    $btnDown = Html::button('-', [
                        'type' => 'button',
                        'class' => 'btn btn-xs btn-default js-skill-count-btn',
                        'title' => 'Decrease',
                        'data-url' => $downUrl,
                        'data-id' => (string)$model->id,
                    ]);
                    $btnUp = Html::button('+', [
                        'type' => 'button',
                        'class' => 'btn btn-xs btn-default js-skill-count-btn',
                        'title' => 'Increase',
                        'data-url' => $upUrl,
                        'data-id' => (string)$model->id,
                    ]);

                    return Html::tag('div', $btnDown . ' ' . $countSpan . ' ' . $btnUp, [
                        'class' => 'skill-count-controls',
                        'style' => 'white-space:nowrap;',
                    ]);
                },
            ],
            [
                'attribute' => 'skillCathegoryName',
                'value' => 'skillCathegory.name',
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Skill $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>

<?php
$this->registerJs(<<<'JS'
(function () {
  document.addEventListener('keydown', function (e) {
    if (e.isComposing) return;
    if (e.key !== 'Enter') return;
    if (e.ctrlKey || e.metaKey || e.altKey || e.shiftKey) return;

    var t = e.target;
    var tag = (t && t.tagName) ? String(t.tagName).toUpperCase() : '';
    if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT' || tag === 'BUTTON' || tag === 'A') return;

    var el = document.querySelector('.js-create-skill');
    if (!el) return;

    e.preventDefault();
    el.click();
  });

  function csrfParam() {
    return (window.yii && yii.getCsrfParam) ? yii.getCsrfParam() : '_csrf';
  }
  function csrfToken() {
    return (window.yii && yii.getCsrfToken) ? yii.getCsrfToken() : null;
  }

  $(document).on('click', '.js-skill-count-btn', function (e) {
    e.preventDefault();
    var $btn = $(this);
    if ($btn.data('busy')) return;

    var url = $btn.data('url');
    var id = $btn.data('id');
    var $count = $('.js-skill-count[data-id="' + id + '"]');
    var $row = $count.closest('tr');

    $btn.data('busy', true).addClass('disabled');

    var data = {};
    var token = csrfToken();
    if (token) data[csrfParam()] = token;

    $.post(url, data)
      .done(function (resp) {
        if (resp && resp.success && typeof resp.count !== 'undefined') {
          var newCount = parseInt(resp.count, 10) || 0;
          $count.text(newCount);

          var level;
          if (newCount <= 0) {
            level = 0;
          } else if (newCount >= 5) {
            level = 5;
          } else {
            level = newCount;
          }

          if ($row && $row.length) {
            // убрать старые классы skill-row-level-X
            $row.removeClass(function (idx, cls) {
              return (cls || '').split(/\s+/).filter(function (c) {
                return c.lastIndexOf('skill-row-level-', 0) === 0;
              }).join(' ');
            });
            // добавить новый
            $row.addClass('skill-row-level-' + level);
          }
        }
      })
      .always(function () {
        $btn.data('busy', false).removeClass('disabled');
      });
  });
})();
JS);
?>
