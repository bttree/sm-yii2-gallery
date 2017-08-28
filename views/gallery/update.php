<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Gallery */

$this->title = \Yii::t('backend', 'Update gallery: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('backend', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = \Yii::t('backend', 'Update');
?>
<div class="gallery-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
