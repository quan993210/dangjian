<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/9/1 0001
 * Time: 21:39
 * 用户信息
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

$action = crequest("action");
$action = $action == '' ? 'get_user_info' : $action;

switch ($action)
{
    case "get_user_info":
        get_user_info();
        break;
    case "mod_user_info":
        mod_user_info();
        break;
    case "upload_avatar":
        upload_avatar();
        break;
    case "update_gender":
        update_gender();
        break;
}
function get_user_info(){
    global $db;
    if(isset($_POST['mobile']) && !empty($_POST['mobile'])&& !empty($_POST['adminid'])) {
        $mobile = addslashes(trim($_POST['mobile']));
        $adminid  = $_POST["adminid"];
        $sql = "SELECT * FROM member WHERE mobile=$mobile and adminid='{$adminid}'";
        $member = $db->get_row($sql);
        showapisuccess($member);
    } else {
        showapierror('参数错误！');
    }
}

function mod_user_info(){
    global $db;
    if(is_array($_POST) && !empty($_POST['userid'])&& !empty($_POST['adminid'])) {
        $userid   = $_POST['userid'];
        $adminid  = $_POST["adminid"];
        $set = "";
        if($_POST['mobile']){
            $mobile   = $_POST['mobile'];
            $set.= "mobile = '{$mobile}'";

            $sql = "SELECT * FROM member WHERE mobile = '{$mobile}' and adminid='{$adminid}'";
            $member = $db->get_row($sql);
            if($member['userid'] != $userid){
                showapierror('系统已存在该手机号，请勿重复添加！');
            }
        }


       if($_POST['name']){
           $name   = $_POST['name'];
           $set.= ", name = '{$name}'";
       }

        if($_POST['nickname']){
            $nickname   = $_POST['nickname'];
            $set.= ", nickname = '{$nickname}'";
        }
        $sql = "UPDATE member SET  $set WHERE userid = '{$userid}' and adminid='{$adminid}'";
        $db->query($sql);
        $sql = "SELECT * FROM member WHERE userid=$userid and adminid='{$adminid}'";
        $member = $db->get_row($sql);
        showapisuccess($member);
    } else {
        //exit('参数错误')
        showapierror('参数错误！');
    }
}

/*------------------------------------------------------ */
//-- 上传头像
/*------------------------------------------------------ */

function upload_avatar()
{
    global $db;
    $userid = irequest('userid');
    $upload_name = 'upload_name';
    $dir_type    = "member";
    $targetDir   = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $dir_type . '/' . date('ym') . '/';

    $cleanupTargetDir = true; // Remove old files
    $maxFileAge = 5 * 3600; // Temp file age in seconds

    // Create target dir
    if (!file_exists($targetDir)) {
        make_dir($targetDir);
    }

    $pos = strrpos($_FILES[$upload_name]["name"], '.');
    if ($pos !== false)
    {
        $file_type = substr($_FILES[$upload_name]["name"], $pos);
    }

    $fileName = date('YmdHis') . rand(1000, 9999) . $file_type;
    $filePath = $targetDir . $fileName;
    $pic_path = '/upload/' . $dir_type . '/' . date('ym') . '/' . $fileName;

    // Chunking might be enabled
    $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
    $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


    // Remove old temp files
    if ($cleanupTargetDir) {
        if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
        }

        while (($file = readdir($dir)) !== false) {
            $tmpfilePath = $targetDir . $file;

            // If temp file is current file proceed to the next
            if ($tmpfilePath == "{$filePath}.part") {
                continue;
            }

            // Remove temp file if it is older than the max age and is not the current file
            if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                @unlink($tmpfilePath);
            }
        }
        closedir($dir);
    }


    // Open temp file
    if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
    }

    if (!empty($_FILES)) {
        if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        }

        // Read binary input stream and append it to temp file
        if (!$in = @fopen($_FILES[$upload_name]["tmp_name"], "rb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
        }
    } else {
        if (!$in = @fopen("php://input", "rb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
        }
    }

    while ($buff = fread($in, 4096)) {
        fwrite($out, $buff);
    }

    @fclose($out);
    @fclose($in);

    // Check if file has been uploaded
    if (!$chunks || $chunk == $chunks - 1) {
        // Strip the temp .part suffix off
        rename("{$filePath}.part", $filePath);
    }

    // Return Success JSON-RPC response
    //die('{"jsonrpc" : "2.0", "result" : null, "pic_path" : "' . '/upload/photo/' . date('ym') . '/' . $fileName . '"}');
    // $session_name = $dir_type . '_' . $upload_name . '_img';
    // $_SESSION[$session_name] = $pic_path;
    //  $res = array("jsonrpc" => "2.0", "result" => "", "pic_path" => $pic_path);
    $adminid  = $_POST["adminid"];
    $pic_path = "https://".$_SERVER["HTTP_HOST"].$pic_path;
    $sql = "UPDATE member SET avatar = '{$pic_path}' WHERE userid = '{$userid}' and adminid='{$adminid}'";
    $db->query($sql);
    $sql = "SELECT * FROM member WHERE userid=$userid and adminid='{$adminid}'";
    $member = $db->get_row($sql);
    showapisuccess($member);
}

function update_gender(){
    global $db;
    $adminid  = $_POST["adminid"];
    $userid = irequest('userid');
    $gender = irequest('gender');
    if(!$gender || !$userid){
        showapierror('参数错误');
    }else{
        $sql = "UPDATE member SET gender = '{$gender}' WHERE userid = '{$userid}' and adminid='{$adminid}'";
        $db->query($sql);
        $sql = "SELECT * FROM member WHERE userid=$userid and adminid='{$adminid}'";
        $member = $db->get_row($sql);
        showapisuccess($member);
    }

}






