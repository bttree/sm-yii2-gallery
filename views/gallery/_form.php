<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\Url;
use kartik\sortable\Sortable;
use bttree\smywidgets\widgets\SlugWidget;

/* @var $this yii\web\View */
/* @var $model bttree\smygallery\models\Gallery */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="gallery-form" id="gallery_image">

        <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

        <?= $form->field($model, 'name')->textInput([
                                                        'maxlength' => true,
                                                        'class'     => 'form-control source-sync-translit',
                                                        'required'  => '',
                                                        'style'     => 'font-weight: bold; font-size: 16px;'
                                                    ]) ?>

        <?= $form->field($model, 'slug')->widget(SlugWidget::className(),
                                                 [
                                                     'sourceFieldSelector' => '#gallery-name',
                                                     'url'                 => ['smygallery/gallery/get-model-slug'],
                                                     'options'             => ['class' => 'form-control']
                                                 ]); ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('smy.gallery', 'Create') :
                                       Yii::t('smy.gallery', 'Update'),
                                   ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

<?php if (!$model->isNewRecord): ?>
    <div class="panel">

        <div class="gallery-images">

            <div id="load_photo_btn">
                <a class="btn btn-info"
                   href="<?= \Yii::$app->urlManager->createUrl([
                                                                   'smygallery/gallery/popup-upload',
                                                                   'id' => $model->id
                                                               ]); ?>"
                   id="upload_link"
                   data-target="#popup-scene-upload"
                   data-toggle="modal">
                    <span><?= Yii::t('smy.gallery', 'Load photo'); ?></span>
                </a>
            </div>


            <?php
            \yii\widgets\Pjax::begin([
                                         'enablePushState' => false,
                                         'id'              => 'company_photos'
                                     ]); ?>

            <?php if ($model->images): ?>

                <?php
                $arrGrid = [];

                foreach ($model->images as $picture) {
                    $arrGrid[] = [
                        "content" => "<div class='grid-item text-danger gallery-image' data-divid='" .
                                     $picture->id .
                                     "'>
                                                    <img src='" .
                                     $picture->getImageUrl(130) .
                                     "' style='height:130px;'>" .
                                     "<span class='glyphicon glyphicon-remove-circle' data-url='" .
                                     Url::to(['gallery/delete-photo', 'photo' => $picture->id]) .
                                     "'></span>"
                                     .
                                     "</div>"
                    ];
                }

                echo Sortable::widget([
                                          'type'         => 'grid',
                                          'items'        => $arrGrid,
                                          'pluginEvents' => [
                                              'sortupdate' => 'function() { 
                            var aR;
                            aR = new Array();
                            
                            var divs = $("ul.sortable li div");
                            for (var i = 0; i < divs.length; i++) {
                                aR[i] = $(divs[i]).attr("data-divid")
                            }
                            
                           $.ajax({
                              type: "GET",
                              url: "/gallery/sort",
                              data: { aR: aR },
                              success: function(msg)
                              {
                              }
                            });
                        }',
                                          ],
                                      ]);
                ?>

            <?php else: ?>
                <?php \kartik\sortable\SortableAsset::register($this); ?>
            <?php endif; ?>

            <?php \yii\widgets\Pjax::end(); ?>
        </div>


    </div>


    <div class="modal fade" id="popup-scene-upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>


    <?php
    $this->registerJs('
    $(document).ready(function(){
        
        
         $("body").on("click", ".gallery-image span", function(event){
            event.preventDefault();
            var url = $(this).data("url");
            var a = $(this);
            $.post(url, function(){$(a).closest(".gallery-image").closest("li").remove()});
        });
        
        $("body").on("click", "#companyimage-src-fileupload button.delete", function(event){
            console.log("reload photos");
            $.pjax.reload({container:"#company_photos"});
        });
        
        $(document).on(\'hidden.bs.modal\', function (e) {
            console.log(\'hidden\');
            $(\'.modal-content\').html(\'\');
            $(e.target).removeData(\'bs.modal\');
        });
    });
');
    ?>

<?php endif; ?>