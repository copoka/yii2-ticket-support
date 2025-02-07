<?php
/**
 * @author akiraz@bk.ru
 * @link https://github.com/copoka/yii2-ticket-support
 * @copyright 2018 copoka
 * @license MIT
 */

namespace copoka\support\commands;

use copoka\support\models\Ticket;
use copoka\support\Module;
use copoka\support\traits\ModuleTrait;
use yii\console\Controller;
use yii\helpers\Console;

class TicketController extends Controller
{
    use ModuleTrait;

    public function actionClose()
    {
        $period = $this->getModule()->countDaysToClose * 86400; // 7 days
        $point = time() - $period;

        if ($this->getModule()->isMongoDb()) {
            $tickets = Ticket::find()
                ->where([
                    'status' => Ticket::STATUS_WAITING,
                    'updated_at' => ['$lt' => new \MongoDB\BSON\UTCDateTime($point * 1000)]
                ])
                ->all();
        } else {
            $tickets = Ticket::find()
                ->where('status=:status AND updated_at<:point', [':point' => $point, ':status' => Ticket::STATUS_WAITING])
                ->all();
        }
        if ($tickets) {
            $ids = [];
            foreach ($tickets as $ticket) {
                $ids[] = $ticket->id;
                $ticket->close();
            }
            $output = implode(', ', $ids);
        }
        $this->stdout(Module::t('support', 'Tickets closed: ' . count($tickets)) . "\n", Console::FG_GREEN);
    }
}
