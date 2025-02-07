<?php
/**
 * @author akiraz@bk.ru
 * @link https://github.com/copoka/yii2-ticket-support
 * @copyright 2018 copoka
 * @license MIT
 */

use copoka\support\models\Category;
use copoka\support\models\Ticket;
// use yii\grid\GridView;
use kartik\grid\GridView;
// use yii\helpers\Html;
use kartik\helpers\Html;
// use yii\jui\DatePicker;
use kartik\date\DatePicker;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel copoka\support\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//////////////////////////////////////////////////////////\/
\copoka\support\assets\TicketAsset::register($this);

/* breadcrumbs */
$this->params['breadcrumbs'][] = $this->title;

/* misc */
/*
$this->registerJs('$(document).on("pjax:send", function(){ $(".grid-view-overlay").removeClass("hidden");});$(document).on("pjax:complete", function(){ $(".grid-view-overlay").addClass("hidden");})');
*/
?>
<div class="ticket-index">
    <div class="box box-primary">
        <div class="box-body">
            <p>
<?= Html::a(\copoka\support\Module::t('support', 'Open Ticket'), ['create'],
['class' => 'btn btn-success']) ?>
            </p>
            <?
/*php Pjax::begin(); 
 */
?>
            <div class="table-responsive">
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'category_id',
            'value' => function ($model) {
                return $model->category ? $model->category->title: '-';
            },
            'filter' => Category::getCatList()
        ],
        'title',

        //['attribute' => 'user_id', 'value' => function ($model){return $model->user->{\Yii::$app->getModule('support')->userName};}],
        [
            'attribute' => 'status',
            'value' => function ($model) {
                return $model->statusColorText;
            },
            'filter' => Ticket::getStatusOption(),
            'format' => 'raw'
        ],
        [
            'attribute' => 'created_at',
            'value' => 'createdAt',
            'format' => 'dateTime',
            'filter' => DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'created_at',
                'pluginOptions' => [
                    'class' => 'form-control',
                    'format' => 'yyyy-MM-dd',
                ]
            ]),
            'contentOptions' => ['style' => 'min-width: 80px']
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'urlCreator' => function ($action, $model, $key, $index) {
                return \yii\helpers\Url::to([$action, 'id' => $model->hash_id]);
            }
],

    ],
]); ?>
            </div>
            <?
/*php Pjax::end(); 
 */
 ?>
        </div>
    </div>
</div>
