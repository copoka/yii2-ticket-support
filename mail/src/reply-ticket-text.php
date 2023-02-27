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
    'ID' => $model->ticket->id,
    'NAME' => !empty($model->user_id) ? $model->user->{\Yii::$app->getModule('support')->userName} : \copoka\support\Module::t('support',
        'Ticket System')
]) ?>

<?= Yii::$app->formatter->asNtext($model->content) ?>


<?= \copoka\support\Module::t('support', 'View Ticket: {URL}', ['URL' => $model->ticket->getUrl(true)]) ?>