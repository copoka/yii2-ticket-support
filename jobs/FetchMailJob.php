<?php
/**
 * @author akiraz@bk.ru
 * @link https://github.com/copoka/yii2-ticket-support
 * @copyright 2018 copoka
 * @license MIT
 */

namespace copoka\support\jobs;

use copoka\support\Mailer;
use copoka\support\models\Ticket;
use copoka\support\traits\ModuleTrait;
use yii\base\BaseObject;

class FetchMailJob extends BaseObject implements \yii\queue\JobInterface
{
    use ModuleTrait;

    public function execute($queue)
    {
        $this->getModule()->fetchMail();
    }
}