<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Client;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/** @var $clientTypes array */
/** @var $client Client */

$this->title = 'Список клиентов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php \yii\bootstrap\Modal::begin([
        'options' => [
            'id'     => 'create-client-modal',
            'header' => '<h2>Создать клиента</h2>',
        ],
    ]) ?>

    <?= $this->render('_form', [
        'model'                => new Client(),
        'clientTypes'          => $clientTypes,
        'redirectToClientPage' => false,
    ]); ?>

    <?php \yii\bootstrap\Modal::end() ?>

    <p>
        <?= Html::button('Создать клиента', [
            'class' => 'btn btn-success create-client',
        ]) ?>
    </p>

    <?php \yii\widgets\Pjax::begin([
        'id' => 'clients-pjax',
    ]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'emptyText'    => 'Клиентов не найдено.',
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'surname',
            'name',
            'patronymic',
            'type',
            [
                'label' => (new Client())->getAttributeLabel('active'),
                'value' => function(Client $model) {
                    return $model->active ? 'Да' : 'Нет';
                },
            ],
            'created_at:datetime',
            'updated_at:datetime',

            [
                'class'   => \yii\grid\ActionColumn::class,
                'buttons' => [
                    'view'   => function($url, $model) {
                        return \yii\helpers\Html::a("<span class='glyphicon glyphicon-eye-open' data-id='{$model->id}'></span>", $url);
                    },
                    'update' => function($url, $model) {
                        return \yii\helpers\Html::button('', [
                            'class'   => 'update-client glyphicon glyphicon-pencil',
                            'data-id' => $model->id,
                        ]);
                    },
                    'delete' => function($url, $model, $key) {
                        $options = [
                            'title'        => 'Удалить',
                            'aria-label'   => 'Удалить',
                            'data-pjax'    => 'clients-pjax',
                            'data-confirm' => 'Вы уверены, что хотите удалить данного клиента?',
                            'data-method'  => 'post',
                            'class'        => '',
                        ];
                        return Html:: a("<span class='glyphicon glyphicon-trash' data-id='{$model->id}'></span>", [
                            'delete',
                            'id' => $model->id,
                        ], $options);
                    },
                ],
            ],
        ],
    ]); ?>

    <?php \yii\widgets\Pjax::end(); ?>
</div>