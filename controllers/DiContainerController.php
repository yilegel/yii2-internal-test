<?php
/**
 * Created by yii2_git.
 * current file name DiContainerConstroller.php.
 * User: waki
 * Date: 2019/4/29
 * Time: 8:54
 */

namespace yii\internal_test\controllers;

use yii\di\Container;
use yii\internal_test\core\CoreController;
use yii\internal_test\Module;

class DiContainerController extends CoreController
{
    public function __construct($id, Module $module, array $config = [])
    {
        $this->id = $id;
        $this->module = $module;
        parent::__construct($id, $module, $config);
        self::$container = new Container();
    }

    public function actionMyContainer()
    {
        $print = self::$container;  //容器里面有8个‘小容器’
//        $print = $this->id; //di-container
//        $print = $this->module;

        /** 使用容器*/
        $this->useContainer();
        $print = self::$container;
        $print = self::$container->get('userLister');
        $print = self::$container;
        /** 这里的容器与上面不同：：$_reflections、$_dependencies只有在调用后（实例化）才能有内容*/
        print_r($print);
        exit();
    }

    public function notUseContainer()
    {
        $db = new \yii\db\Connection(['dsn' => 'mysql:host=106.12.118.30;dbname=gupiao', 'username' => 'waki', 'password' => 'Waki@900623',]);
        $finder = new UserFinder($db);
        $lister = new UserLister($finder);
    }

    public function useContainer()
    {
        $container = self::$container;
        $container->set('yii\db\Connection', ['dsn' => 'mysql:host=106.12.118.30;dbname=gupiao', 'username' => 'waki', 'password' => 'Waki@900623',]);
        $container->set('yii\internal_test\controllers\UserFinderInterface', [
            'class' => 'yii\internal_test\controllers\UserFinder',
        ]);
        $container->set('userLister', 'yii\internal_test\controllers\UserLister');
    }

    public function actionIndex()
    {
        print_r('yii2依赖注入容器的使用，对比不使用容器（实例的顺序、数量不方便）');
    }
}

interface UserFinderInterface
{
    function findUser();
}

use yii\db\Connection;
use yii\base\Object;

// 定义类，实现接口
class UserFinder extends Object implements UserFinderInterface
{
    public $db;

    // 从构造函数看，这个类依赖于 Connection
    public function __construct(Connection $db, $config = [])
    {
        $this->db = $db;
        parent::__construct($config);
    }

    public function findUser()
    {
    }
}

class UserLister extends Object
{
    public $finder;

    // 从构造函数看，这个类依赖于 UserFinderInterface接口
    public function __construct(UserFinderInterface $finder, $config = [])
    {
        $this->finder = $finder;
        parent::__construct($config);
    }
}