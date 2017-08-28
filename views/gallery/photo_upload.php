<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><?= \Yii::t('backend', 'Add photo') ;?></h4>
</div>
<div class="modal-body company-photo">
    <div id="fileupload-wrap" style="width: 820px; margin: 40px 0 40px 0;">
        <?= dosamigos\fileupload\FileUploadUI::widget([
            'model' => $model,
            'attribute' => 'src',
            'url' => ['gallery/photo-upload', 'gallery_id' => $gallery_id],
            'gallery' => false,


            'fieldOptions' => [
                'accept' => 'image/*'
            ],
            'clientOptions' => [
                'maxFileSize' => 15000000
            ],

            'clientEvents' => [
                'fileuploaddone' => 'function(e, data) {
                                                $(".btn-upload-close").addClass("uploaded");
                                            }',
                'fileuploadfail' => 'function(e, data) {
                                            }',
                'fileuploadstop' => 'function(e, data) {
                                                $.pjax.reload({container:"#company_photos"});
                                            }',
            ],
        ]);
        ?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-upload-close" data-dismiss="modal"><?= \Yii::t('backend', 'Close') ;?></button>
</div>