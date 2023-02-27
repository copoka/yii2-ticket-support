<?php
/**
 * @author akiraz@bk.ru
 * @link https://github.com/copoka/yii2-ticket-support
 * @copyright 2018 copoka
 * @license MIT
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \copoka\support\models\Ticket */
?>

<?= \copoka\support\Module::t('support', 'Hello Admin,') ?>

<?= \copoka\support\Module::t('support', '{USER} ({EMAIL}) have opened a ticket with the following message:', [
    'USER' => Html::encode($model->user->{\Yii::$app->getModule('support')->userName}),
    'EMAIL' => Html::encode($model->user->{\Yii::$app->getModule('support')->userEmail})
]) ?>


<?= $model->title ?>

<?= Yii::$app->formatter->asNtext($model->content) ?>



<?= \copoka\support\Module::t('support', 'View Ticket: {URL}', ['URL' => $model->getUrl(true)]) ?>