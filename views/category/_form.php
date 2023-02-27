<?php
/**
 * @author akiraz@bk.ru
 * @link https://github.com/copoka/yii2-ticket-support
 * @copyright 2018 copoka
 * @license MIT
 */

use copoka\support\models\Category;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model copoka\support\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(Category::getStatusOption()) ?>

    <div class="form-group">
        <?= \yii\helpers\Html::submitButton($model->isNewRecord ? \copoka\support\Module::t('support', 'Create') :
            \copoka\support\Module::t('support', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
