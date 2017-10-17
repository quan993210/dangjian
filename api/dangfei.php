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
define('MCH_ID','1487989782');
define('WX_KEY','jiangxijinlukejikaifa5803015gong');
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
}

function my_dangfei(){
    global $db;
    if(isset($_POST['mobile']) && !empty($_POST['mobile']) &&isset($_POST['userid']) && !empty($_POST['userid']) ) {
        $mobile = trim($_POST['mobile']);
        $userid = trim($_POST['userid']);
        $sql = "SELECT a.*,b.title FROM dangfei_data as a LEFT JOIN dangfei as b on a.dangfeiid=b.id WHERE a.mobile =$mobile and a.userid =$userid ORDER BY id DESC";
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

        $sql = "SELECT * FROM `dangfei_data` WHERE dangfeiid='{$dangfeiid}' and id='{$dangfei_data_id}' and userid='{$userid}'";
        $dangfei_data = $db->get_row($sql);
        if(!$dangfei_data){
            showapierror('支付党费信息不存在！');
        }
        if($dangfei_data['status'] == 2){
            showapierror('已支付订单请勿重复=发起请求！');
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
            $orderinfo['openid'] = $openid;
            wx_pay($orderinfo);
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
    $cost = intval($info['cost']*100);   //微信金额以分为单位
    if(empty($info['openid'])){
        showapierror('登录失效，请重新登录(openid参数有误)！');
    }
    if(empty($info['ordersn'])){
        showapierror('订单生产失败！');
    }
    $appid =        APPID;//如果是公众号 就是公众号的appid;小程序就是小程序的appid
    $body =         '党费';
    $mch_id =       MCH_ID; //商户号
    $KEY =         WX_KEY;    //微信支付key
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
    $post['total_fee'] = $cost ;        //总金额 最低为一分钱 必须是整数
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
               <total_fee>'.$cost .'</total_fee>
               <trade_type>'.$trade_type.'</trade_type>
               <sign>'.$sign.'</sign>
            </xml> ';

    //统一下单接口prepay_id
    $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    $xml = http_request($url,$post_xml);     //POST方式请求http

    $array = xmlToObject($xml);               //将【统一下单】api返回xml数据转换成数组，全要大写

    if($array['return_code'] == 'SUCCESS'){
        $time = time();
        $tmp=array();                            //临时数组用于签名
        $tmp['appId'] = $appid;
        $tmp['nonceStr'] = $nonce_str;
        $tmp['package'] = 'prepay_id='.$array['prepay_id'];
        $tmp['signType'] = 'MD5';
        $tmp['timeStamp'] = "$time";
        //print_r($tmp);

        $data['state'] = 1;
        $data['timeStamp'] = "$time";           //时间戳
        $data['nonceStr'] = $nonce_str;         //随机字符串
        $data['signType'] = 'MD5';              //签名算法，暂支持 MD5
        $data['package'] = 'prepay_id='.$array['prepay_id'];   //统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
        $data['paySign'] = MakeSign($tmp,$KEY);       //签名,具体签名方案参见微信公众号支付帮助文档;
        $data['out_trade_no'] = $out_trade_no;
        showapisuccess($data);

    }else{
        showapierror($array['return_msg']);
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



function getNonceStr() {
    $code = "";
    for ($i=0; $i > 10; $i++) {
        $code .= mt_rand(10000);
    }
    $nonceStrTemp = md5($code);
    $nonce_str = mb_substr($nonceStrTemp, 5,37);
    return $nonce_str;
}

