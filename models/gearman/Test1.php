<?php
/**
 * Created by yii2_git.
 * current file name test1.php.
 * User: waki
 * Date: 2019/5/5
 * Time: 12:02
 */

namespace yii\internal_test\models\gearman;


use yii\base\Component;
use GearmanClient;
use GearmanWorker;

class Test1 extends Component
{
    public function __construct()
    {
        $worker = new GearmanWorker();
        $worker->addServer();
        $worker->addFunction("reverse", function ($job) {
            return strrev($job->workload());
        });
        while ($worker->work());
    }

    public function diaoyong()
    {
        $client = new GearmanClient();
        $client->addServer();
        print $client->do("reverse", "Hello World!");
    }
}