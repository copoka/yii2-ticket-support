<?php
/**
 * @author akiraz@bk.ru
 * @link https://github.com/copoka/yii2-ticket-support
 * @copyright 2018 copoka
 * @license MIT
 */

namespace copoka\support\controllers;

use copoka\support\components\BackendFilter;
use copoka\support\jobs\FetchMailJob;
use copoka\support\models\Ticket;
use copoka\support\traits\ModuleTrait;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `ticket` module
 */
class DefaultController extends Controller
{
    use ModuleTrait;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $array = [];
        if (!$this->getModule()->yii2basictemplate) {
            $array = ['backend' => [
                'class' => BackendFilter::className(),
                'actions' => [
                    '*',
                ],
            ]];
        }
        
        return array_merge($array, [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return $this->getModule()->adminMatchCallback;
                        },
                    ],
                ],
            ],
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFetchMail()
    {
        $id = \Yii::$app->get($this->getModule()->queueComponent)->push(new FetchMailJob());
        if ($id) {
            \Yii::$app->session->setFlash('success', \copoka\support\Module::t('support', 'Added job to fetch tickets from mailbox, please wait'));
        }
        return $this->redirect(['/support/ticket/manage']);
    }
}
