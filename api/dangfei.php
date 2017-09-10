<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/7 0007
 * Time: 21:23
 * 党费
 */
define('WE_NOTIFY_URL','https://dangjian.famishare.me/api/pay_notify.php');
define('APPID','wx6ce6752b26628e64');
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

$action = crequest("action");
$action = $action == '' ? 'my_dangfei' : $action;

switch ($action)
{
    case "my_dangfei":
        my_dangfei();
        break;
    case "create_order":
        create_order();
        break;
    case "pay_notify":
        pay_notify();
        break;
}

function my_dangfei(){
    global $db;
    if(isset($_POST['mobile']) && !empty($_POST['mobile']) ) {
        $mobile = trim($_POST['mobile']);
        $sql = "SELECT a.*,b.title FROM dangfei_data as a LEFT JOIN dangfei as b on a.dangfeiid=b.id WHERE a.mobile =$mobile ORDER BY id DESC";
        $news = $db->get_all($sql);
        showapisuccess($news);
    }else{
        showapierror('参数错误！');
    }
}

function create_order(){
    global $db;

    $userid = isset($_POST['userid']) ? trim($_POST['userid']) : showapierror('userid_error');
    $sql = "SELECT * FROM member WHERE userid='{$userid}'";
    $userinfo = $db->get_row($sql);
    if(!$userinfo){
        showapierror('user_not_find');
    }

    if (empty($openid)){
        $openid = $userinfo['openid'];
    }
    if (empty($openid)){
        showapierror('openid获取失败');
    }


    if(!empty($_POST['dangfeiid']) && !empty($_POST['dangfei_data_id']) && !empty($_POST['name']) && !empty($_POST['cost'])){
        $dangfeiid = $_POST['dangfeiid'];
        $dangfei_data_id = $_POST['dangfei_data_id'];
        $userid = $_POST['userid'];

        $sql = "SELECT * FROM `order` WHERE dangfeiid='{$dangfeiid}' and dangfei_data_id='{$dangfei_data_id}' and userid='{$userid}'";
        $info = $db->get_row($sql);
        if(is_array($info) && $info){
            wx_pay($info);
        }else{
            $name = $_POST['name'];
            $cost = $_POST['cost'];
            $ordersn = date('Ymd').substr(microtime(), 2,3).rand(1000,9999);
            $add_time = time();
            $add_time_format = now_time();
            $status = 1;
            $sql = "INSERT INTO `order` (dangfeiid,dangfei_data_id,userid, name, cost, ordersn,add_time,add_time_format,status) VALUES ('{$dangfeiid}','{$dangfei_data_id}','{$userid}', '{$name}', '{$cost}', '{$ordersn}', '{$add_time}', '{$add_time_format}','{$status}')";
            $db->query($sql);
            $sql = "SELECT * FROM `order` WHERE ordersn='{$ordersn}'";
            $orderinfo = $db->get_row($sql);
            if (!$orderinfo){
                showapierror('order_error');
            }

            $sql = "SELECT * FROM `order` WHERE ordersn='{$ordersn}'";
            $info = $db->get_row($sql);
            $info['openid'] = $openid;
            wx_pay($info);
        }

    }else{
        showapierror('参数错误！');
    }
}




/* 首先在服务器端调用微信【统一下单】接口，返回prepay_id和sign签名等信息给前端，前端调用微信支付接口 */
function wx_pay($info){
    if(empty($info['cost'])){
        showapierror('金额有误！');
    }
    if(empty($info['openid'])){
        showapierror('登录失效，请重新登录(openid参数有误)！');
    }
    if(empty($info['ordersn'])){
        showapierror('订单生产失败！');
    }
    $appid =        APPID;//如果是公众号 就是公众号的appid;小程序就是小程序的appid
    $body =         $info['add_time_format'].'党费';
    $mch_id =       '商户账号';
    $KEY = '微信支付key';
    $nonce_str =    getNonceStr();//随机字符串
    $notify_url =   WE_NOTIFY_URL;  //支付完成回调地址url,不能带参数
    $out_trade_no =  $info['ordersn'];//商户订单号
    $spbill_create_ip =  real_ip();
    $trade_type = 'JSAPI';//交易类型 默认JSAPI

    //这里是按照顺序的 因为下面的签名是按照(字典序)顺序 排序错误 肯定出错
    $post['appid'] = $appid;
    $post['body'] = $body;
    $post['mch_id'] = $mch_id;
    $post['nonce_str'] = $nonce_str;//随机字符串
    $post['notify_url'] = $notify_url;
    $post['openid'] = $info['openid'];
    $post['out_trade_no'] = $out_trade_no;
    $post['spbill_create_ip'] = $spbill_create_ip;//服务器终端的ip
    $post['total_fee'] = intval($info['cost']);        //总金额 最低为一分钱 必须是整数
    $post['trade_type'] = $trade_type;
    $sign = MakeSign($post,$KEY);              //签名

    $post_xml = '<xml>
               <appid>'.$appid.'</appid>
               <body>'.$body.'</body>
               <mch_id>'.$mch_id.'</mch_id>
               <nonce_str>'.$nonce_str.'</nonce_str>
               <notify_url>'.$notify_url.'</notify_url>
               <openid>'.$info['openid'].'</openid>
               <out_trade_no>'.$out_trade_no.'</out_trade_no>
               <spbill_create_ip>'.$spbill_create_ip.'</spbill_create_ip>
               <total_fee>'.$info['cost'].'</total_fee>
               <trade_type>'.$trade_type.'</trade_type>
               <sign>'.$sign.'</sign>
            </xml> ';

    //统一下单接口prepay_id
    $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    $xml = http_request($url,$post_xml);     //POST方式请求http
    $array = xml2array($xml);               //将【统一下单】api返回xml数据转换成数组，全要大写
    if($array['RETURN_CODE'] == 'SUCCESS' && $array['RESULT_CODE'] == 'SUCCESS'){
        $time = time();
        $tmp='';                            //临时数组用于签名
        $tmp['appId'] = $appid;
        $tmp['nonceStr'] = $nonce_str;
        $tmp['package'] = 'prepay_id='.$array['PREPAY_ID'];
        $tmp['signType'] = 'MD5';
        $tmp['timeStamp'] = "$time";

        $data['state'] = 1;
        $data['timeStamp'] = "$time";           //时间戳
        $data['nonceStr'] = $nonce_str;         //随机字符串
        $data['signType'] = 'MD5';              //签名算法，暂支持 MD5
        $data['package'] = 'prepay_id='.$array['PREPAY_ID'];   //统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
        $data['paySign'] = MakeSign($tmp,$KEY);       //签名,具体签名方案参见微信公众号支付帮助文档;
        $data['out_trade_no'] = $out_trade_no;
        showapisuccess($data);

    }else{
        $data['state'] = 0;
        $data['text'] = "错误";
        $data['RETURN_CODE'] = $array['RETURN_CODE'];
        $data['RETURN_MSG'] = $array['RETURN_MSG'];
        showapierror('订单生产失败！',$data);
    }

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
/**
 * 调用接口， $data是数组参数
 * @return 签名
 */
function http_request($url,$data = null,$headers=array())
{
    $curl = curl_init();
    if( count($headers) >= 1 ){
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }
    curl_setopt($curl, CURLOPT_URL, $url);

    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
//获取xml里面数据，转换成array
function xml2array($xml){
    $p = xml_parser_create();
    xml_parse_into_struct($p, $xml, $vals, $index);
    xml_parser_free($p);
    $data = "";
    foreach ($index as $key=>$value) {
        if($key == 'xml' || $key == 'XML') continue;
        $tag = $vals[$value[0]]['tag'];
        $value = $vals[$value[0]]['value'];
        $data[$tag] = $value;
    }
    return $data;
}


function getNonceStr() {
    $code = "";
    for ($i=0; $i > 10; $i++) {
        $code .= mt_rand(10000);
    }
    $nonceStrTemp = md5($code);
    $nonce_str = mb_substr($nonceStrTemp, 5,37);
    return $nonce_str;
}

