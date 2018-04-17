<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/10 0010
 * Time: 22:27
 * 微信支付回调
 */
/* 微信支付完成，回调地址url方法 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();
global $db;

$post = post_data();    //接受POST数据XML个数
$post_data = xmlToObject($post);   //微信支付成功，返回回调地址url的数据：XML转数组Array
$postSign = $post_data['sign'];
unset($post_data['sign']);
/* 微信官方提醒：
 *  商户系统对于支付结果通知的内容一定要做【签名验证】,
 *  并校验返回的【订单金额是否与商户侧的订单金额】一致，
 *  防止数据泄漏导致出现“假通知”，造成资金损失。
 */


if($post_data['return_code']=='SUCCESS'&&$postSign){

    $sql = "SELECT * FROM  `order` WHERE ordersn='{$post_data['out_trade_no']}'";
    $orderinfo = $db->get_row($sql);

    $adminid  = $_POST["adminid"];
    $sql = "SELECT * FROM admin WHERE id = '{$orderinfo['adminid']}'";
    $res = $db->get_row($sql);
    define('APPID',$res['appid']);
    define('MCH_ID',$res['mch_id']);
    define('WX_KEY',$res['wx_key']);
    define('APPSECRET',$res['appsecret']);

    $KEY =         WX_KEY;    //微信支付key
    $user_sign = MakeSign($post_data,$KEY);

    if($postSign !=$user_sign){
        $error['errcode'] = '100005';
        $error['errmsg'] = '签名错误！';
        wx_error_log(__FILE__,$error);
        insert_error_log($error);
        exit();
    }


//查询订单是否存在
    if (!$orderinfo){
        $error['errcode'] = '100001';
        $error['errmsg'] = '订单不存在';
        wx_error_log(__FILE__,$error);
        insert_error_log($error);
        exit();
    }
    /*
    * 首先判断，订单是否已经更新为ok，因为微信会总共发送8次回调确认
    * 其次，订单已经为ok的，直接返回SUCCESS
    * 最后，订单没有为ok的，更新状态为ok，返回SUCCESS
    */

    //判断交易金额是否正确
    if (intval($post_data['total_fee']) != $orderinfo['cost']*100){
        $error['errcode'] = '100002';
        $error['errmsg'] = '订单金额不匹配';
        wx_error_log(__FILE__,$error);
        insert_error_log($error);
        exit();
    }
    //判读appid是否正确
    if ($post_data['appid'] != APPID){
        $error['errcode'] = '100003';
        $error['errmsg'] = 'appid错误';
        wx_error_log(__FILE__,$error);
        insert_error_log($error);
        exit();
    }

    if($orderinfo['status']=='2'){
        return_success();
    }else{
        $channel = "微信小程序支付";
        $status = 2;
        $ordersn = $post_data['out_trade_no'];
        $pay_time	= time();
        $pay_time_format	= now_time();
        $sql = "UPDATE `order` SET channel = '{$channel}',pay_time = '{$pay_time}',pay_time_fromat = '{$pay_time_format}',status = '{$status}' WHERE  ordersn=$ordersn";
        $db->query($sql);
        $sql = "UPDATE dangfei_data SET status = '{$status}' WHERE id='{$orderinfo['dangfei_data_id']}'";
        $db->query($sql);
        return_success();

    }
}else{
    $error['errcode'] = '100004';
    $error['errmsg'] = $postSign['return_msg'];
   //$error['adminid'] = $adminid;
    wx_error_log(__FILE__,$error);
    insert_error_log($error);
    exit();
}


function post_data(){
    $receipt = $_REQUEST;
    if($receipt==null){
        $receipt = file_get_contents("php://input");
        if($receipt == null){
            $receipt = $GLOBALS['HTTP_RAW_POST_DATA'];
        }
    }
    wx_log(__FILE__,$receipt);
    return $receipt;
}



//获取xml里面数据，转换成array
function xmlToObject($xmlStr) {
    if (!is_string($xmlStr) || empty($xmlStr)) {
        return false;
    }
    $postObj = simplexml_load_string($xmlStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    $postObj = json_decode(json_encode($postObj));
    return object_to_array($postObj);
}
function object_to_array($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)object_to_array($v);
        }
    }

    return $obj;
}

/**
 * 生成签名, $KEY就是支付key
 * @return 签名
 */
function MakeSign( $params,$KEY){
    //签名步骤一：按字典序排序数组参数
    ksort($params);
    $string = ToUrlParams($params);  //参数进行拼接key=value&k=v
    //签名步骤二：在string后加入KEY
    $string = $string . "&key=".$KEY;
    //签名步骤三：MD5加密
    $string = md5($string);
    //签名步骤四：所有字符转为大写
    $result = strtoupper($string);
    return $result;
}

/**
 * 将参数拼接为url: key=value&key=value
 * @param $params
 * @return string
 */
function ToUrlParams( $params ){
    $string = '';
    if( !empty($params) ){
        $array = array();
        foreach( $params as $key => $value ){
            $array[] = $key.'='.$value;
        }
        $string = implode("&",$array);
    }
    return $string;
}

/*
 * 给微信发送确认订单金额和签名正确，SUCCESS信息 -xzz0521
 */
function return_success(){
    $return['return_code'] = 'SUCCESS';
    $return['return_msg'] = 'OK';
    $xml_post = '<xml>
                    <return_code>'.$return['return_code'].'</return_code>
                    <return_msg>'.$return['return_msg'].'</return_msg>
                    </xml>';
    echo $xml_post;exit;
}

