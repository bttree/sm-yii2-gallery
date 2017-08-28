<?php

namespace bttree\smygallery\models;

use Yii;
use bttree\smyimage\behaviors\ImageUploadBehavior;

/**
 * This is the model class for table "gallery_image".
 *
 * @property integer $id
 * @property integer $gallery_id
 * @property string  $src
 * @property string  $name
 * @property string  $description
 */
class GalleryImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{gallery_image}}';
    }


    public function behaviors()
    {
        return [
            'sortable'            => [
                'class'      => 'common\behaviors\SortableBehavior',
                'sortColumn' => 'pos'
            ],
            'imageUploadBehavior' => [
                'class'         => ImageUploadBehavior::className(),
                'attribute'     => 'src',
                'resizeOptions' => [
                    'width'  => 800,
                    'height' => 600
                ]
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gallery_id', 'pos'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 3000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'gallery_id'  => 'Gallery ID',
            'src'         => \Yii::t('smy.gallery', 'Source'),
            'name'        => \Yii::t('smy.gallery', 'Name'),
            'description' => \Yii::t('smy.gallery', 'Description'),
        ];
    }

    public function getImageSrc()
    {
        return $this->getImageUrl();
    }
}
