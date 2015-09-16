<?php
/**
 * @var View $this
 * @var SourceMessage $model
 */

use yii\helpers\Html;
use yii\web\View;
use Zelenin\yii\modules\I18n\models\SourceMessage;
use Zelenin\yii\modules\I18n\Module;

$this->title = Module::t('Update') . ': ' . $model->message;
echo \yii\widgets\Breadcrumbs::widget(['links' => [
	['label' => Module::t('Translations'), 'url' => ['index']],
	['label' => $this->title]
]]);
?>
<div class="message-update">
	<div class="message-form">

		<div class="form-group">
			<label class="control-label"><?=Module::t('Source message')?></label>
			<input type="text" disabled class="form-control" value="<?=Html::encode($model->message)?>">
		</div>

		<?php $form = \yii\bootstrap\ActiveForm::begin(); ?>
		<div class="field">
			<div class="ui grid">
				<?php foreach ($model->messages as $language => $message) : ?>
					<div class="four wide column">
						<?= $form->field($model->messages[$language], '[' . $language . ']translation')->label($language) ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
		</div>
		<?php $form::end(); ?>
	</div>
</div>
