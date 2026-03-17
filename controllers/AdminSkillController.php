<?php

namespace app\controllers;

use app\models\tables\Skill;
use app\models\tables\SkillCathegory;
use app\models\filters\SkillSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * AdminSkillController implements the CRUD actions for Skill model.
 */
class AdminSkillController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'count-up' => ['POST'],
                        'count-down' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Skill models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SkillSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Skill model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Skill model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Skill();
        $skillCathegoryList = SkillCathegory::getCathegories();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'skillCathegoryList' => $skillCathegoryList,
        ]);
    }

    /**
     * Updates an existing Skill model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $skillCathegoryList = SkillCathegory::getCathegories();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'skillCathegoryList' => $skillCathegoryList,
        ]);
    }

    /**
     * Deletes an existing Skill model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCountUp($id)
    {
        $model = $this->findModel($id);
        $current = (int)($model->count ?? 0);
        $new = $current + 1;

        $model->updateAttributes(['count' => (string)$new]);

        $this->response->format = Response::FORMAT_JSON;
        return ['success' => true, 'id' => (int)$model->id, 'count' => $new];
    }

    public function actionCountDown($id)
    {
        $model = $this->findModel($id);
        $current = (int)($model->count ?? 0);
        $new = max(0, $current - 1);

        $model->updateAttributes(['count' => (string)$new]);

        $this->response->format = Response::FORMAT_JSON;
        return ['success' => true, 'id' => (int)$model->id, 'count' => $new];
    }

    /**
     * Finds the Skill model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Skill the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Skill::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
