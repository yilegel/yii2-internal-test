<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/4/25
 * Time: 18:01
 */

namespace yii\internal_test\models;


use yii\base\Component;

class TestModel extends Component
{
    public $propertyName;

    public function mokuai(){
        print_r("自定义模块的输出");
    }
}