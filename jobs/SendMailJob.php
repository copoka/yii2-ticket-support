<?php
/**
 * @author akiraz@bk.ru
 * @link https://github.com/copoka/yii2-ticket-support
 * @copyright 2018 copoka
 * @license MIT
 */

namespace copoka\support\jobs;

use copoka\support\Mailer;
use copoka\support\models\Content;
use copoka\support\traits\ModuleTrait;
use yii\base\BaseObject;

class SendMailJob extends BaseObject implements \yii\queue\JobInterface
{
    use ModuleTrait;

    public $contentId;

    public function execute($queue)
    {
        $content = Content::findOne(['id' => $this->contentId]);
        if ($content !== null) {
            $email = $content->ticket->user_contact;
            /* send email */
            $subject = \copoka\support\Module::t('support', '[{APP} Ticket #{ID}] Re: {TITLE}',
                ['APP' => \Yii::$app->name, 'ID' => $content->ticket->hash_id, 'TITLE' => $content->ticket->title]);

            $this->mailer->sendMessage(
                $email,
                $subject,
                'reply-ticket',
                ['title' => $subject, 'model' => $content]
            );

        }
    }

    protected function getMailer()
    {
        return \Yii::$container->get(Mailer::className());
    }
}