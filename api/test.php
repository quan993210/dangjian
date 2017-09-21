<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/21 0021
 * Time: 20:37
 * 测试
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

$action = crequest("action");
$action = $action == '' ? 'sign' : $action;

switch ($action)
{
    case "get_test":
        get_test();
        break;
    case "creat_dati":
        creat_dati();
        break;
    case "submit_dati":
        submit_dati();
        break;
    case "submit_test":
        submit_test();
        break;
}


function get_test(){
    global $db;
    if(isset($_POST['testid']) && !empty($_POST['testid']) ) {
        $testid = intval(trim($_POST['testid']));
        $sql = "SELECT * FROM test WHERE testid ='{$testid}' and is_delete =0 ORDER BY testid DESC";
        $test = $db->get_row($sql);
        showapisuccess($test);
    }else{
        $sql = "SELECT * FROM test WHERE is_delete =0 ORDER BY testid DESC";
        $test = $db->get_all($sql);
        showapisuccess($test);
    }
}

function creat_dati(){
    global $db;
    if(!empty($_POST['userid']) && !empty($_POST['testid'])) {
        $now_time = now_time();
        $time = time();
        $userid = $_POST['userid'];
        $sql = "SELECT * FROM member WHERE userid='{$userid}'";
        $member = $db->get_row($sql);
        if(!is_array($member) && !$member){
            showapierror('参数错误！');
        }

        //获取答题的题目
        $testid = $_POST['testid'];
        $sql = "SELECT a.id as test_timu_id, b.* FROM test_timu as a LEFT JOIN timu as b on a.timuid=b.timuid WHERE a.testid='{$testid}' ORDER BY id ASC";
        $test_timu = $db->get_all($sql);
        if(!is_array($test_timu) && !$test_timu){
            showapierror('参数错误！');
        }

       /* $sql = "SELECT * FROM test_dati WHERE userid='{$userid}' and testid='{$testid}'";
        $dati = $db->get_row($sql);
        if(is_array($dati) && $dati){
            //重新点击  存在答题记录
            $test_dati_id = $dati['id'];
        }else{
            //创建答题记录
            $sql = "INSERT INTO test_dati (userid,username,testid,status,add_time,add_time_format) VALUES ('{$userid}','{$member['nickname']}','{$testid}', '{$time}','{$now_time}')";
            $db->query($sql);
            $test_dati_id = $db->link_id->insert_id;
        }*/

        //创建答题记录
        $sql = "INSERT INTO test_dati (userid,username,testid,status,add_time,add_time_format) VALUES ('{$userid}','{$member['name']}','{$testid}', '1','{$time}','{$now_time}')";
        $db->query($sql);
        $test_dati_id = $db->link_id->insert_id;


        //获取题目答案
        foreach($test_timu as $key=>$val){
            $sql 		= "SELECT * FROM timu_answer WHERE timuid = '{$val['timuid']}' ORDER BY id ASC";
            $answer 		= $db->get_all($sql);
            $test_timu[$key]['answer'] = $answer;
        }
        $test_dati['testid'] = $testid;
        $test_dati['test_dati_id'] = $test_dati_id;
        $test_dati['timu'] = $test_timu;
        showapisuccess($test_dati);
    }else{
        showapierror('参数错误！');
    }

}

function submit_dati(){
    global $db;
    $now_time = now_time();
    $time = time();
    if(!empty($_POST['userid']) && !empty($_POST['testid']) && !empty($_POST['test_dati_id']) && !empty($_POST['timuid']) && !empty($_POST['test_timu_id']) && !empty($_POST['answer'])) {
        //检查答题用户
        $userid = $_POST['userid'];
        $sql = "SELECT * FROM member WHERE userid='{$userid}'";
        $member = $db->get_row($sql);
        if(!is_array($member) && !$member){
            showapierror('参数错误！');
        }

        //获取试卷=》计算每道题目分数
        $testid = $_POST['testid'];
        $sql = "SELECT * FROM test WHERE testid='{$testid}'";
        $test = $db->get_row($sql);
        if(!is_array($test) && !$test){
            showapierror('参数错误！');
        }
        $score = 100/ $test['limit_count'];

        //获取答题记录用于更新答题分数
        $test_dati_id = $_POST['test_dati_id'];
        $sql = "SELECT * FROM test_dati WHERE id='{$test_dati_id}'";
        $test_dati = $db->get_row($sql);
        if(!is_array($test_dati) && !$test_dati){
            showapierror('参数错误！');
        }

        //获取题目答案，校验答题是否正确
        $timuid = $_POST['timuid'];
        $sql = "SELECT * FROM timu WHERE timuid='{$timuid}'";
        $timu = $db->get_row($sql);
        if(!is_array($timu) && !$timu){
            showapierror('参数错误！');
        }
        $answer =  $_POST['answer'];
        if($timu['correct'] == $answer){
            $is_correct = 1;
            $test_dati['score'] = $test_dati['score'] +$score;
            $test_dati['score'] = $test_dati['score'] > 100 ? 100:$test_dati['score'];
        }else{
            $is_correct = 2;
        }

        //更新答题记录分数
        $update_col = "score = '{$test_dati['score']}'";
        $sql = "UPDATE test_dati SET {$update_col} WHERE userid = '{$userid}' and testid =  '{$testid}'";
        $db->query($sql);


        $test_timu_id =$_POST['test_timu_id'];
        //插入答题明显表
        $sql = "INSERT INTO test_dati_detail (testid,test_dati_id,userid,username,timuid,test_timu_id,answer,is_correct,add_time,add_time_format)
              VALUES ('{$testid}','{$test_dati_id}','{$userid}','{$member['name']}','{$timuid}','{$test_timu_id}','{$answer}','{$is_correct}','{$time}','{$now_time}')";
        $db->query($sql);
        $test_dati['test_timu_id']= $test_timu_id;
        $test_dati['is_correct']=$is_correct;
        showapisuccess($test_dati);
    }else{
        showapierror('参数错误！');
    }

}

function submit_test()
{
    global $db;
    $now_time = now_time();
    $time = time();
    if (!empty($_POST['userid']) && !empty($_POST['testid'])) {

    } else {
        showapierror('参数错误！');
    }
}


