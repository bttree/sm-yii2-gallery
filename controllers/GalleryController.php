<?php

namespace bttree\smygallery\controllers;

use Yii;
use bttree\smygallery\models\Gallery;
use bttree\smygallery\models\GalleryImage;
use bttree\smygallery\models\SearchGallery;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use bttree\smywidgets\actions\GetModelSlugAction;

/**
 * GalleryController implements the CRUD actions for Gallery model.
 */
class GalleryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only'  => [
                    'index',
                    'view',
                    'create',
                    'update',
                    'delete',
                    'popup-upload',
                    'photo-upload',
                    'sort',
                    'delete-photo'
                ],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => [
                            'index',
                            'view',
                            'create',
                            'update',
                            'delete',
                            'popup-upload',
                            'photo-upload',
                            'sort',
                            'delete-photo'
                        ],
                        'roles'   => ['galleryManage'],
                    ],
                ],
            ],
        ];
    }


    public function actions()
    {
        return [
            'get-model-slug' => [
                'class'     => GetModelSlugAction::className(),
                'modelName' => Gallery::className()
            ],
        ];
    }


    /**
     * Lists all Gallery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new SearchGallery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index',
                             [
                                 'searchModel'  => $searchModel,
                                 'dataProvider' => $dataProvider,
                             ]);
    }

    /**
     * @param  integer $id
     * @return mixed
     */
    public function actionPopupUpload($id = 0)
    {
        if (Yii::$app->request->isAjax) {
            $gallery = $this->findModel($id);
            $model   = new GalleryImage();

            return $this->renderAjax('photo_upload', ['model' => $model, 'gallery_id' => $id, 'gallery' => $gallery]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param  integer $gallery_id
     * @return string
     */
    public function actionPhotoUpload($gallery_id)
    {

        $model = new GalleryImage([
                                      'gallery_id' => $gallery_id,
                                  ]);

        $gallery        = Gallery::find()->where(['id' => $gallery_id])->with('images')->one();
        $gallery_images = $gallery->images;
        if ($gallery_images) {
            $model->pos = count($gallery_images) + 1;
        } else {
            $model->pos = 1;
        }

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Фотографии загружены');

            return Json::encode([
                                    'files' => [
                                        [
                                            'title'        => $model->name ? $model->name : '',
                                            'size'         => '',
                                            "url"          => '',
                                            "thumbnailUrl" => $model->getImageUrl($width = 80),
                                            "deleteUrl"    => '/gallery/delete-photo?photo=' . $model->id,
                                            "deleteType"   => "POST"
                                        ]
                                    ]
                                ]);
        }

        return '';
    }

    /**
     * @param  string $photo
     * @return string
     */
    public function actionDeletePhoto($photo)
    {
        $photo          = GalleryImage::findOne(['id' => $photo]);
        $gallery        = Gallery::findOne(['id' => $photo->gallery_id]);
        $gallery_images = $gallery->getImages()->where(['>', 'pos', $photo->pos])->all();
        if ($gallery_images) {
            foreach ($gallery_images as $item) {
                $item->pos = $item->pos - 1;
                $item->save();
            }
        }

        if ($photo->delete()) {
            Yii::$app->session->setFlash('success', 'Фото удалено');

            return 'ok';
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось удалить фото');

            return 'ok';
        }
    }


    /**
     * Displays a single Gallery model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view',
                             [
                                 'model' => $this->findModel($id),
                             ]);
    }

    /**
     * Creates a new Gallery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Gallery();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create',
                                 [
                                     'model' => $model,
                                 ]);
        }
    }

    /**
     * Updates an existing Gallery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->addFlash('success', 'Successfuly saved');

            return $this->redirect(['index']);
        } else {
            return $this->render('update',
                                 [
                                     'model' => $model,
                                 ]);
        }
    }

    /**
     * Deletes an existing Gallery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Gallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gallery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
