<?php
/**
 * Created by yii2_git.
 * current file name PhpStreamRedis.php.
 * User: waki
 * Date: 2019/5/4
 * Time: 11:18
 */

namespace yii\internal_test\models\my_redis;


class PhpStreamRedis
{
    public function directStreamRedis()
    {
        $redis = stream_socket_client('tcp://106.12.118.30:6379', $errno, $errstr, 5);

        if (!$redis)
        {
            die('连接redis服务器失败: ' . $errstr);
        }


// 查询代码....
        $cmd = "*1\r\n$6\r\nDBSIZE\r\n";  //dbsize
        fwrite($redis, $cmd, strlen($cmd));
        $ret = fread($redis, 4096);
        echo $ret;
        echo "----------------------\r\n";

        $cmd = "*3\r\n$3\r\nset\r\n$6\r\nstream\r\n$42\r\ndirect use stream to connect and use redis\r\n"; //set foobar redis   最后一个$xx xx必须<=字符串长度
        fwrite($redis, $cmd, strlen($cmd));
        $ret = fread($redis, 4096);
        echo $ret;
        echo "----------------------------\r\n";

        $cmd = "*2\r\n$3\r\nget\r\n$6\r\nstream\r\n";  //get foobar
        fwrite($redis, $cmd, strlen($cmd));
        $ret = fread($redis, 4096);
        echo $ret;
        echo "----------------------------\r\n";

        $cmd = "*4\r\n$4\r\nhset\r\n$7\r\nanimals\r\n$3\r\ncat\r\n$3\r\ntom\r\n";  //hset animals cat tom
        fwrite($redis, $cmd, strlen($cmd));
        $ret = fread($redis, 4096);
        echo $ret;
        echo "-------------------------------------\r\n";

        $cmd = "*2\r\n$5\r\nhkeys\r\n$7\r\nanimals\r\n";  //hkeys animals
        fwrite($redis, $cmd, strlen($cmd));
        $ret = fread($redis, 4096);
        echo $ret;
        echo "-------------------------------------\r\n";

        stream_socket_shutdown($redis, STREAM_SHUT_RDWR);
    }
}


 
