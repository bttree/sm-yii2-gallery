<?php

namespace bttree\smygallery\models;

use Yii;
use bttree\smyimage\behaviors\ImageUploadBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "gallery_image".
 *
 * @property integer $id
 * @property integer $gallery_id
 * @property string  $src
 * @property string  $name
 * @property string  $description
 * @property string  $pos
 *
 * @property Gallery $gallery
 *
 * @method string getImageUrl($width = 0, $height = 0, $crop = false, $stretch = false)
 * @method void removeFile()
 */
class GalleryImage extends ActiveRecord
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
            'src'         => Yii::t('smy.gallery', 'Source'),
            'name'        => Yii::t('smy.gallery', 'Name'),
            'description' => Yii::t('smy.gallery', 'Description'),
        ];
    }

    /**
     * @return string
     */
    public function getImageSrc()
    {
        return $this->getImageUrl();
    }

    /**
     * @return string
     */
    public function getGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'gallery_id']);
    }
}
