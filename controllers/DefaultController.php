<?php

namespace yii\internal_test\controllers;

use yii\internal_test\core\CoreController;
use yii\internal_test\models\TestModel;
/**
 * Default controller for the `haha` module
 */
class DefaultController extends CoreController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    /** yii的扩展
     在GitHub、packagist都注册好之后，还是不能使用composer自动安装，所有就改用手动安装
     * 整个加载原来：
     * 在 extension.php中添加别名，在配置文件中配置Moudle，就可以访问了
     */
    public function actionIndex()
    {
//        return $this->render('index');
//        (new TestModel())->mokuai();
//        $print = \Yii::$app->extensionComponent;
//        $print = \Yii::$app->components;
//        $print = \Yii::$app->container;
//        $print = \Yii::$app->behaviors();
        $print = \Yii::$app->bootstrap;
        print_r($print);
        print_r(YII_DEBUG);
        \Yii::warning("直接用最大的类Yii写日志");

        print_r(self::$container); //为什么不能跨类使用，不是说容器内的东西是公用的吗？？？？？？？？？？？？？？？？？？？？？？？？
    }
}
