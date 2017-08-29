<?php

/* @var $this yii\web\View */
/* @var $model bttree\smygallery\models\Gallery */

$this->title                   = \Yii::t('smy.gallery', 'Update gallery: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('smy.gallery', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = \Yii::t('smy.gallery', 'Update');
?>
<div class="gallery-update">
    <?= $this->render('_form',
                      [
                          'model' => $model,
                      ]) ?>
</div>