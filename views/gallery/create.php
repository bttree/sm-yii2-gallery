<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model bttree\smygallery\models\Gallery */

$this->title                   = Yii::t('smy.gallery', 'Create gallery');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('smy.gallery', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form',
                      [
                          'model' => $model,
                      ]) ?>

</div>