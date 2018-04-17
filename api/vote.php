<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2018/1/15 0015
 * Time: 20:51
 * 投票
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

$action = crequest("action");
$action = $action == '' ? 'get_vote' : $action;

switch ($action)
{
    case "get_vote":
        get_vote();
        break;
    case "add_vote":
        add_vote();
        break;
}

function get_vote(){
    global $db;
    $adminid  = $_POST["adminid"];
    if(isset($_POST['voteid']) && !empty($_POST['voteid'])  && !empty($_POST['adminid']) ) {
        $voteid = intval(trim($_POST['voteid']));
        $sql = "SELECT * FROM vote WHERE id =$voteid and is_delete =0 and adminid='{$adminid}'";
        $vote = $db->get_row($sql);
        if($vote['end_time'] > time()){
            $vote['isend'] = 1;
        }else{
            $vote['isend'] = 0;
        }
        $sql = "SELECT * FROM vote_option WHERE vote_id =$voteid and adminid='{$adminid}'";
        $vote_option = $db->get_all($sql);
        $vote['option'] = $vote_option;

        showapisuccess($vote);
    }else{
        showapierror('参数错误');
    }
}

function add_vote(){
    global $db;
    if(!empty($_POST['userid'])&& !empty($_POST['adminid'])&& !empty($_POST['voteid'])&& !empty($_POST['vote_option_id']) ) {
        $vote_option_ids = explode(',',$_POST['vote_option_id']);
        $userid = intval(trim($_POST['userid']));
        $adminid  = $_POST["adminid"];
        $voteid  = $_POST["voteid"];
        foreach($vote_option_ids as $val){
            $sql = "SELECT * FROM vote_option WHERE id =$val and adminid='{$adminid}'";
            $vote_option = $db->get_row($sql);
            if(!$vote_option){
                showapierror($val.'选项错误，投票失败！');
            }
            $option['num'] = $vote_option['num']+1;
            $info['userid'] = $userid;
            $info['adminid'] = $adminid;
            $info['voteid'] = $voteid;
            $info['vote_option_id'] = $val;
            $info['add_time'] = time();
            $info['add_time_format'] = now_time();
            $db->insert('vote_data',$info);
            $db->update('vote_option',$option,"id=$val and adminid=$adminid");
        }
        $sql = "SELECT * FROM vote_option WHERE vote_id =$voteid and adminid='{$adminid}'";
        $vote_option = $db->get_all($sql);
        showapisuccess($vote_option,'投票成功');
    }else{
        showapierror('参数错误！');
    }
}
