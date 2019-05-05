<?php
/**
 * Created by yii2_git.
 * current file name RedisController.php.
 * User: waki
 * Date: 2019/5/4
 * Time: 11:23
 */

namespace yii\internal_test\controllers;


use yii\internal_test\models\my_redis\RedisExtension;
use yii\web\Controller;
use yii\internal_test\models\my_redis\PhpStreamRedis;

class RedisController extends Controller
{
    public function actionStreamDirect()
    {
        $streamDirect = new PhpStreamRedis();

        $streamDirect->directStreamRedis();
    }

    public function actionStreamPackaging(){
        $redis = new RedisExtension();
//        $redis->connect('106.12.118.30', 6379);
        $redis->connect();

        $redis->exec('set', 'foo', 'phpredis');
        $redis->exec('hset', 'animals', 'dog', 'spike');
        $redis->exec('hset', 'animals', 'cat', 'tom');
        $redis->exec('hset', 'animals', 'mouse', 'jerry');

        var_dump($redis->exec('get', 'foo'));
        var_dump($redis->exec('dbsize'));
        print_r($redis->exec('hkeys', 'animals'));

// pipeline
        $redis->initPipeline();
        $redis->exec('incr', 'Count');
        $redis->exec('incr', 'Count');
        $redis->exec('hgetall', 'animals');
        print_r($redis->commitPipeline());

        $redis->close();
    }
}