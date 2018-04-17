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
    case "my_test":
        my_test();
        break;
}


function get_test(){
    global $db;
    if(isset($_POST['userid']) && !empty($_POST['userid']) && !empty($_POST['adminid']) ) {
        $userid = $_POST['userid'];
        $adminid  = $_POST["adminid"];
        if(isset($_POST['testid']) && !empty($_POST['testid']) ) {
            $testid = intval(trim($_POST['testid']));
            $sql = "SELECT * FROM test WHERE testid ='{$testid}' and is_delete =0 and adminid='{$adminid}'ORDER BY testid DESC";
            $test = $db->get_row($sql);

            if($db->get_one("SELECT * FROM test_dati WHERE testid = '{$test['testid']}' and userid ='{$userid}' and status =2 and adminid='{$adminid}'")){
                $status = 2;
                $sql        = "select score from test_dati WHERE testid = '{$test['testid']}' and userid ='{$userid}' and status =2 and adminid='{$adminid}' order by score DESC";
                $score 		= $db->get_one($sql);
            }elseif($db->get_one("SELECT * FROM test_dati WHERE testid = '{$test['testid']}' and userid ='{$userid}' and status =1 and adminid='{$adminid}'")){
                $status = 1;
                $score = 0;
            }else{
                $status = 0;
                $score = 0;
            }
            $test['score'] = $score;
            $test['status'] = $status;
            $test['userid'] = $userid;
            showapisuccess($test);
        }else{
            $sql = "SELECT * FROM test WHERE is_delete =0 and adminid='{$adminid}' ORDER BY testid DESC";
            $test = $db->get_all($sql);

            foreach($test as $key=>$val){
                if($db->get_one("SELECT * FROM test_dati WHERE testid = '{$val['testid']}' and userid ='{$userid}' and status =2 and adminid='{$adminid}'")){
                    $status = 2;
                    $sql        = "select score from test_dati WHERE testid = '{$val['testid']}' and userid ='{$userid}' and status =2 and adminid='{$adminid}' order by score DESC";
                    $score 		= $db->get_one($sql);
                }elseif($db->get_one("SELECT * FROM test_dati WHERE testid = '{$val['testid']}' and userid ='{$userid}' and status =1 and adminid='{$adminid}'")){
                    $status = 1;
                    $score = 0;
                }else{
                    $status = 0;
                    $score = 0;
                }
                $test[$key]['score'] = $score;
                $test[$key]['status'] = $status;
                $test[$key]['userid'] = $userid;

            }
            showapisuccess($test);
        }
    }else{
        showapierror('参数错误！');
    }

}

function creat_dati(){
    global $db;
    if(!empty($_POST['userid']) && !empty($_POST['testid'])&& !empty($_POST['adminid'])) {
        $adminid  = $_POST["adminid"];
        $now_time = now_time();
        $time = time();
        $userid = $_POST['userid'];
        $sql = "SELECT * FROM member WHERE userid='{$userid}' and adminid='{$adminid}'";
        $member = $db->get_row($sql);
        if(!is_array($member) && !$member){
            showapierror('参数错误！');
        }


        //获取答题的题目
        $testid = $_POST['testid'];
        $sql = "SELECT a.id as test_timu_id, b.* FROM test_timu as a LEFT JOIN timu as b on a.timuid=b.timuid WHERE a.testid='{$testid}' and a.adminid='{$adminid}' ORDER BY id ASC";
        $test_timu = $db->get_all($sql);
        if(!is_array($test_timu) && !$test_timu){
            showapierror('参数错误！');
        }

        $sql = "SELECT * FROM test WHERE testid='{$testid}' and adminid='{$adminid}'";
        $test = $db->get_row($sql);
        if($test['flg'] == 1){
            if($test['grade'] != $member['grade'] ||$test['rank_title'] != $member['rank_title'] || $test['identity'] != $member['identity'] || $test['position'] != $member['position'] || $test['is_party_affairs'] != $member['is_party_affairs'] || $test['is_discipline'] != $member['is_discipline'] ||$test['is_prepare'] != $member['is_prepare'] ||$test['is_retire'] != $member['is_retire'] ){
                showapierror('不是会议指定人群，禁止答题');
            }
        }

        $test_dati_id = $_POST['test_dati_id'];
        //重新点击  存在答题记录
        if($test_dati_id){
            //获取已经提交过得答题
            $test_dati_id = $_POST['test_dati_id'];
            $sql = "SELECT test_timu_id FROM test_dati_detail WHERE test_dati_id='{$test_dati_id}' and userid='{$userid}' and adminid='{$adminid}'";
            $test_dati_detail = $db->get_all($sql);
            if(!is_array($test_dati_detail) && !$test_dati_detail){
                showapierror('参数错误！');
            }
            $a2 = array();
            foreach($test_dati_detail as $val){
                $a2[] = $val['test_timu_id'];
            }

            $a1 = array();
            foreach($test_timu as $val){
                $a1[] = $val['test_timu_id'];
            }

            //判断提交试卷中的题目是否全部答过
            $result = array_diff($a1,$a2);
            if($result){
                foreach($result as $id){
                    $sql = "SELECT a.id as test_timu_id, b.* FROM test_timu as a LEFT JOIN timu as b on a.timuid=b.timuid WHERE a.id='{$id}' and a.adminid='{$adminid}'";
                    $result_timu[] = $db->get_row($sql);
                }

                //获取题目答案
                foreach($result_timu as $key=>$val){
                    $sql 		= "SELECT * FROM timu_answer WHERE timuid = '{$val['timuid']}' and adminid='{$adminid}' ORDER BY id ASC";
                    $answer 		= $db->get_all($sql);
                    $result_timu[$key]['answer'] = $answer;
                }
            }else{
                $result_timu[] = ""; //已答完
            }
            $test_dati['testid'] = $testid;
            $test_dati['test_dati_id'] = $test_dati_id;
            $test_dati['timu'] = $result_timu;
            showapisuccess($test_dati);
        }else{
            //创建答题记录
            $sql = "INSERT INTO test_dati (userid,username,testid,status,add_time,add_time_format,adminid) VALUES ('{$userid}','{$member['name']}','{$testid}', '1','{$time}','{$now_time}','{$adminid}')";
            $db->query($sql);
            $test_dati_id = $db->link_id->insert_id;


            //获取题目答案
            foreach($test_timu as $key=>$val){
                $sql 		= "SELECT * FROM timu_answer WHERE adminid='{$adminid}' and timuid = '{$val['timuid']}' ORDER BY id ASC";
                $answer 		= $db->get_all($sql);
                $test_timu[$key]['answer'] = $answer;
            }
            $test_dati['testid'] = $testid;
            $test_dati['test_dati_id'] = $test_dati_id;
            $test_dati['timu'] = $test_timu;
            showapisuccess($test_dati);
        }


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
        $adminid  = $_POST["adminid"];
        $sql = "SELECT * FROM member WHERE userid='{$userid}' and adminid='{$adminid}'";
        $member = $db->get_row($sql);
        if(!is_array($member) && !$member){
            showapierror('参数错误！');
        }

        //获取试卷=》计算每道题目分数
        $testid = $_POST['testid'];
        $sql = "SELECT * FROM test WHERE testid='{$testid}' and adminid='{$adminid}'";
        $test = $db->get_row($sql);
        if($test['flg'] == 1){
            if($test['grade'] != $member['grade'] ||$test['rank_title'] != $member['rank_title'] || $test['identity'] != $member['identity'] || $test['position'] != $member['position'] || $test['is_party_affairs'] != $member['is_party_affairs'] || $test['is_discipline'] != $member['is_discipline'] ||$test['is_prepare'] != $member['is_prepare'] ||$test['is_retire'] != $member['is_retire'] ){
                showapierror('不是会议指定人群，禁止答题');
            }
        }
        if(!is_array($test) && !$test){
            showapierror('参数错误！');
        }
        $score = floor( 100/ $test['limit_count']);

        //获取答题记录用于更新答题分数
        $test_dati_id = $_POST['test_dati_id'];
        $sql = "SELECT * FROM test_dati WHERE id='{$test_dati_id}' and adminid='{$adminid}'";
        $test_dati = $db->get_row($sql);
        if(!is_array($test_dati) && !$test_dati){
            showapierror('参数错误！');
        }

        //获取题目答案，校验答题是否正确
        $timuid = $_POST['timuid'];
        $sql = "SELECT * FROM timu WHERE timuid='{$timuid}' and adminid='{$adminid}'";
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
        $sql = "UPDATE test_dati SET {$update_col} WHERE userid = '{$userid}' and testid =  '{$testid}' and id ='{$test_dati_id}' and adminid='{$adminid}'";
        $db->query($sql);


        $test_timu_id =$_POST['test_timu_id'];
        //插入答题明显表
        $sql = "INSERT INTO test_dati_detail (testid,test_dati_id,userid,username,timuid,test_timu_id,answer,is_correct,add_time,add_time_format,adminid)
              VALUES ('{$testid}','{$test_dati_id}','{$userid}','{$member['name']}','{$timuid}','{$test_timu_id}','{$answer}','{$is_correct}','{$time}','{$now_time}','{$adminid}')";
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
    if (!empty($_POST['userid']) && !empty($_POST['testid']) && !empty($_POST['test_dati_id'])) {
        //检查答题用户
        $userid = $_POST['userid'];
        $adminid  = $_POST["adminid"];
        $sql = "SELECT * FROM member WHERE userid='{$userid}' and adminid='{$adminid}'";
        $member = $db->get_row($sql);
        if(!is_array($member) && !$member){
            showapierror('参数错误！');
        }

        //获取试卷题目
        $testid = $_POST['testid'];
        $sql = "SELECT id FROM test_timu WHERE testid='{$testid}' and adminid='{$adminid}'";
        $test_timu = $db->get_all($sql);
        if(!is_array($test_timu) && !$test_timu){
            showapierror('参数错误！');
        }
        $a1 = array();
        foreach($test_timu as $val){
            $a1[] = $val['id'];
        }

        //获取已经提交过得答题
        $test_dati_id = $_POST['test_dati_id'];
        $sql = "SELECT test_timu_id FROM test_dati_detail WHERE test_dati_id='{$test_dati_id}' and userid='{$userid}' and adminid='{$adminid}'";
        $test_dati_detail = $db->get_all($sql);
        if(!is_array($test_dati_detail) && !$test_dati_detail){
            showapierror('参数错误！');
        }

        $a2 = array();
        foreach($test_dati_detail as $val){
            $a2[] = $val['test_timu_id'];
        }

        //判断提交试卷中的题目是否全部答过
        $result = array_diff($a1,$a2);
        if($result){
            $complete = 0;  //未答完题目
            $test_timu_ids = implode(',',$result);
        }else{
            $complete = 1; //已答完
        }

        //更新答题记录分数
        $update_col = "status = '2'";
        $sql = "UPDATE test_dati SET {$update_col} WHERE userid = '{$userid}' and testid =  '{$testid}' and adminid='{$adminid}'";
        $db->query($sql);

        $sql = "SELECT * FROM test_dati WHERE id='{$test_dati_id}' and userid = '{$userid}' and testid =  '{$testid}' and adminid='{$adminid}'";
        $test_dati = $db->get_row($sql);
        $test_dati['complete'] = $complete;
        $test_dati['test_timu_ids'] = $test_timu_ids;

        $sql = "SELECT * FROM test_dati_detail WHERE test_dati_id='{$test_dati_id}' and userid = '{$userid}' and testid =  '{$testid}' and adminid='{$adminid}' and is_correct = 2";
        $test_dati['error_timu'] = $db->get_all($sql);
        foreach($test_dati['error_timu'] as $key=>$val){
            $sql = "SELECT title FROM timu WHERE timuid='{$val['timuid']}' and adminid='{$adminid}'";
            $timu = $db->get_row($sql);
            $test_dati['error_timu'][$key]['title'] = $timu['title'];
        }

        showapisuccess($test_dati);

    } else {
        showapierror('参数错误！');
    }
}

function my_test(){
    global $db;
    if (!empty($_POST['userid'])) {
        //检查答题用户
        $userid = $_POST['userid'];
        $adminid  = $_POST["adminid"];
        $sql = "SELECT a.*,b.title,b.limit_count,b.limit_time FROM test_dati as a LEFT JOIN test as b on a.testid = b.testid WHERE a.userid='{$userid}' and a.adminid='{$adminid}'";
        $test_dati = $db->get_all($sql);
        if(!is_array($test_dati) && !$test_dati){
            showapierror('参数错误！');
        }
        showapisuccess($test_dati);
    }else {
        showapierror('参数错误！');
    }
}


