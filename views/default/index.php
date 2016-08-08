<?php
/**
 * @var View $this
 * @var SourceMessageSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 * @var int $languagesCount
 */

use Wancer\yii\modules\I18n\models\search\SourceMessageSearch;
use Wancer\yii\modules\I18n\models\SourceMessage;
use Wancer\yii\modules\I18n\Module;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use \yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;

$this->title = Module::t('Translations');
echo Breadcrumbs::widget(['links' => [
	$this->title
]]);
?>
<div class="message-index">
	<div class="pull-right">
		<a class="btn btn-danger" href="<?=Url::toRoute('/translations/flush-untranslated')?>">Remove untranslated</a>
	</div>

	<h3><?= Html::encode($this->title) ?></h3>
	<?php
	Pjax::begin();
	echo GridView::widget([
		'filterModel' => $searchModel,
		'dataProvider' => $dataProvider,
		'columns' => [
			[
				'attribute' => 'id',
				'value' => function ($model)
				{
					return $model->id;
				},
				'filter' => false
			],
			[
				'attribute' => 'message',
				'format' => 'raw',
				'value' => function (SourceMessage $model)
				{
					return Html::a($model->message, ['update', 'id' => $model->id], ['data' => ['pjax' => 0]]);
				}
			],
			[
				'attribute' => 'category',
				'value' => function (SourceMessage $model)
				{
					return $model->category;
				},
				'filter' => ArrayHelper::map($searchModel::getCategories(), 'category', 'category')
			],
			[
				'attribute' => 'status',
				'value' => function (SourceMessage $model) use ($languagesCount)
				{
					$count = 0;
					foreach ($model->messages as $message)
					{
						$count += (bool)(!empty($message->translation));
					}

					if ($count == $languagesCount)
					{
						$text = Module::t('Translated');
					}
					else
					{
						$text = Module::t('Not translated');
					}

					return $text;
				},
				'filter' => $searchModel->getStatus()
			]
		]
	]);
	Pjax::end();
	?>
</div>
