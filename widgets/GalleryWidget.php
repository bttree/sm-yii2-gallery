<?php

namespace bttree\smygallery\widgets;

use bttree\smygallery\models\Gallery;


class GalleryWidget extends \yii\bootstrap\Widget
{

    public $view = 'index';
    public $gallery_id;
    public $id = '';
    public $class = '';
    public $url = false;

    public function init()
    {
        parent::init();

    }

    public function run() {

        $gallery = Gallery::findOne($this->gallery_id);
        $pictures = false;

        if($gallery){
            $pictures = $gallery->images;
        }

        return $this->render($this->view, ['pictures' => $pictures,
                                           'id'       => $this->id,
                                           'class'    => $this->class,
                                           'url'      => $this->url,
                                          ]);
    }
}
