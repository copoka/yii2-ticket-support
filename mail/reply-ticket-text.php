<?php
/**
 * @author akiraz@bk.ru
 * @link https://github.com/copoka/yii2-ticket-support
 * @copyright 2018 copoka
 * @license MIT
 */

/* @var $this yii\web\View */
/* @var $model \copoka\support\models\Content */
?>
<?= \copoka\support\Module::t('support', 'Ticket #{ID}: New reply from {NAME}:', [
    'ID' => $model->ticket->hash_id,
    'NAME' => $model->getUsername()
]) ?>

<?= Yii::$app->formatter->asNtext($model->content) ?>
