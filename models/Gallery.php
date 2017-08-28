<?php

namespace bttree\smygallery\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "gallery".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $slug
 */
class Gallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{gallery}}';
    }


    public function behaviors()
    {
        return [
            [
                'class'         => SluggableBehavior::className(),
                'attribute'     => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique'  => true
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'   => 'ID',
            'name' => \Yii::t('backend', 'Name'),
            'slug' => \Yii::t('backend', 'Slug'),
        ];
    }

    public function getImages()
    {
        return $this->hasMany(GalleryImage::className(), ['gallery_id' => 'id'])
                    ->orderBy('gallery_image.pos');
    }

}
