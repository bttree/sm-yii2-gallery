<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model bttree\smygallery\models\Gallery */

$this->title                   = $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('smy.gallery', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(\Yii::t('smy.gallery', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(\Yii::t('smy.gallery', 'Delete'),
                    ['delete', 'id' => $model->id],
                    [
                        'class' => 'btn btn-danger',
                        'data'  => [
                            'confirm' => \Yii::t('smy.gallery', 'Are you sure you want to delete this item?'),
                            'method'  => 'post',
                        ],
                    ]) ?>
    </p>

    <?= DetailView::widget([
                               'model'      => $model,
                               'attributes' => [
                                   'id',
                                   'name',
                                   'slug',
                               ],
                           ]) ?>

</div>
