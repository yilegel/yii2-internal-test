<?php
/**
 * Created by yii2_git.
 * current file name GearmanController.php.
 * User: waki
 * Date: 2019/5/5
 * Time: 12:05
 */

namespace yii\internal_test\controllers;


use yii\internal_test\models\gearman\Test1;
use yii\internal_test\models\TestModel;
use yii\web\Controller;

class GearmanController extends Controller
{
    public function actionIndex(){
        print_r("测试gearman");
    }

    public function actionTest1()
    {
        $test1 = new Test1();
        $test1->diaoyong();
    }
}