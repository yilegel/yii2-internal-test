<?php
/**
 * Created by yii2_git.
 * current file name DuoXianChengController.php.
 * User: waki
 * Date: 2019/5/4
 * Time: 15:25
 */

namespace yii\internal_test\controllers;


use yii\web\Controller;
use Yii;
/** 没有测试成功只是给了一个大概的理解*/
class DuoXianChengController extends Controller
{
    public function actionSendStream() {
//        $english_format_number = number_format($number, 4, '.', '');
//
//        echo $english_format_number;
//        exit();
        $timeout = 10;
        $result = array();
        $sockets = array();
        $convenient_read_block = 8192;
        $host = "test.local.com";
        $sql = "select waybill_id,order_id from xm_waybill where status>40 order by update_time desc limit 1 ";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        $id = 0;

        foreach ($data as $k => $v) {
            if ($k % 2 == 0) {
                $send_data[$k]['body'] = NoticeOrder::getSendData($v['waybill_id']);

            } else {
                $send_data[$k]['body'] = array($v['order_id'] => array('extra' => 16));
            }
            $data = json_encode($send_data[$k]['body']);
            $s = stream_socket_client($host . ":80", $errno, $errstr, $timeout, STREAM_CLIENT_ASYNC_CONNECT | STREAM_CLIENT_CONNECT);
            if ($s) {
                $sockets[$id++] = $s;
                $http_message = "GET /php/test.php?data=" . $data . " HTTP/1.0\r\nHost:" . $host . "\r\n\r\n";
                fwrite($s, $http_message);
            } else {
                echo "Stream " . $id . " failed to open correctly.";
            }
        }

        while (count($sockets)) {

            $read = $sockets;

            stream_select($read, $w = null, $e = null, $timeout);
            if (count($read)) {
                /* stream_select generally shuffles $read, so we need to
                 compute from which socket(s) we're reading. */
                foreach ($read as $r) {

                    $id = array_search($r, $sockets);
                    $data = fread($r, $convenient_read_block);
                    if (strlen($data) == 0) {
                        echo "Stream " . $id . " closes at " . date('h:i:s') . ".<br>  ";
                        fclose($r);
                        unset($sockets[$id]);
                    } else {
                        $result[$id] = $data;
                    }
                }
            } else {
                /* A time-out means that *all* streams have failed
                 to receive a response. */
                echo "Time-out!\n";
                break;
            }
        }
        print_r($result);

    }
}