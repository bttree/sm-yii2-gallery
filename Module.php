<?php

namespace bttree\smygallery;

use Yii;
/**
 * page module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'bttree\smygallery\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        if (!isset(Yii::$app->i18n->translations['smy.gallery'])) {
            Yii::$app->i18n->translations['smy.gallery'] = [
                'class'          => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'ru',
                'basePath'       => '@bttree/smygallery/messages'
            ];
        }
    }
}