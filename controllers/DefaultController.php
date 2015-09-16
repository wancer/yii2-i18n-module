<?php

namespace Wancer\yii\modules\I18n\controllers;

use Yii;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Wancer\yii\modules\I18n\models\search\SourceMessageSearch;
use Wancer\yii\modules\I18n\models\SourceMessage;
use Wancer\yii\modules\I18n\Module;

/**
 * Class DefaultController
 * @package Wancer\yii\modules\I18n\controllers
 */
class DefaultController extends Controller
{
	/**
	 * @return string
	 */
	public function actionIndex()
	{
		$searchModel = new SourceMessageSearch;
		$dataProvider = $searchModel->search(Yii::$app->getRequest()->get());
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider
		]);
	}

	/**
	 * @param integer $id
	 * @return string|Response
	 */
	public function actionUpdate($id)
	{
		/** @var SourceMessage $model */
		$model = $this->findModel($id);
		$model->initMessages();

		if (Model::loadMultiple($model->messages, Yii::$app->getRequest()->post()) && Model::validateMultiple($model->messages))
		{
			$model->saveMessages();
			Yii::$app->getSession()->setFlash('success', Module::t('Updated'));
			return $this->redirect(['update', 'id' => $model->id]);
		} else
		{
			return $this->render('update', ['model' => $model]);
		}
	}

	/**
	 * @param array|integer $id
	 * @return SourceMessage|SourceMessage[]
	 * @throws NotFoundHttpException
	 */
	protected function findModel($id)
	{
		$query = SourceMessage::find()->where('id = :id', [':id' => $id]);
		$models = is_array($id)
			? $query->all()
			: $query->one();
		if (!empty($models))
		{
			return $models;
		} else
		{
			throw new NotFoundHttpException(Module::t('The requested page does not exist'));
		}
	}
}
