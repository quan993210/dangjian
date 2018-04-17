<?php
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
define('BD_APP_ID',10871419);
define('BD_API_KEY','74gv9lTzWiVZNxyqMqXBYiEs');
define('BD_SECRET_KEY','cpP5hWMTyllhgmeIvVXaddnXQqEaGSd0');


$action = crequest("action");
$action = $action == '' ? 'list' : $action; 

switch ($action) 
{
		case "list":
                      news_list();
					  break;			  
	   	case "add_news":
                      add_news();
					  break;
		case "do_add_news":
                      do_add_news();
					  break;
	   	case "mod_news":
                      mod_news();
					  break;
		case "do_mod_news":
                      do_mod_news();
					  break;
		case "del_news":
                      del_news();
					  break;
	   	case "del_sel_news":
                      del_sel_news();
					  break;				  					  	
	   	case "del_one_img":
                      del_one_img();
					  break;
		case "upload_batch_photo":
                      upload_batch_photo();
					  break;
		case "checkChild":
			checkChild();
			break;

}

function get_con()
{
	global $smarty;
	$adminid  = $_SESSION["admin_id"];
	$con = "WHERE a.is_delete=0 and a.adminid = $adminid";
	//新闻分类
	$catid = irequest('catid');
	$smarty->assign('catid', $catid);
	if (!empty($catid))
	{
		$con .=" AND a.catid = '{$catid}' ";
	}

	$lables = irequest('lables');
	$smarty->assign('lable', $lables);
	if (!empty($lables))
	{
		$con .=" AND a.lables like  '%{$lables}%'";
	}
	//关键字
	$keyword = crequest('keyword');
	$smarty->assign('keyword', $keyword);
	if (!empty($keyword))
	{
		$con .= " AND a.title like '%{$keyword}%' ";
	}
	
	
	return $con;
}

/*------------------------------------------------------ */
//-- 新闻列表
/*------------------------------------------------------ */	
function news_list()
{
	global $db, $smarty;
	
	//搜索条件
	$con 		= get_con(); 
	
	//排序字段
	$order 	 	 = 'ORDER BY a.listorder DESC, id DESC';
	
	//列表信息
	$now_page 	= irequest('page');
	$now_page 	= $now_page == 0 ? 1 : $now_page;	
	$page_size 	= 20;
	$start    	= ($now_page - 1) * $page_size;	
	$sql 		= "SELECT a.*, c.catname AS catname FROM news AS a LEFT JOIN news_category AS c ON a.catid = c.catid {$con} {$order} LIMIT {$start}, {$page_size}";
	$arr 		= $db->get_all($sql);
	
	$sql 		= "SELECT COUNT(a.id) FROM news AS a {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));
	
	$smarty->assign('news_list'  ,   $arr);
	$smarty->assign('pageshow'  ,   $page->show(6));
	$smarty->assign('now_page'  ,   $page->now_page);
	
	//表信息
	$tbl = array('tbl' => 'news', 'col1' => 'title', 'col2' => 'is_top');			
	$smarty->assign('tbl', $tbl);
	
	//新闻分类
	$smarty->assign('news_category', get_news_category());
	$smarty->assign('lables',  get_lables());
    $smarty->assign('page_title', '新闻列表');
	$smarty->display('news/news_list.htm');	
}

/*------------------------------------------------------ */
//-- 添加新闻
/*------------------------------------------------------ */	
function add_news()
{
	global $smarty;

	//新闻分类
	$smarty->assign('news_category',  get_news_category());
	$smarty->assign('vote',  get_vote());
	$smarty->assign('lables',  get_lables());
	
	if (!empty($_SESSION['image1']))
	{
		$news['image1'] = $_SESSION['image1'];
	}
	if (!empty($_SESSION['image2']))
	{
		$news['image2'] = $_SESSION['image2'];
	}
	if (!empty($_SESSION['image3']))
	{
		$news['image3'] = $_SESSION['image3'];
	}
	
	$smarty->assign('news', $news);
	$smarty->assign('action', 'do_add_news');
	$smarty->assign('page_title', '添加新闻');
	$smarty->display('news/news.htm');
}

/*------------------------------------------------------ */
//-- 添加新闻
/*------------------------------------------------------ */	
function do_add_news()
{
	global $db;
	$adminid  = $_SESSION["admin_id"];
	$info = $_POST['info'];
	$info['add_time']	= time();
	$info['add_time_format']	= now_time();
	$info['adminid'] = $adminid;
	$lables = $_POST['lables'];
	$info['lables'] = implode(',',$lables);

	check_null($info['catid'], 			'分类');
	check_null($info['title'], 			'标题');
	check_null($info['content'], 			'新闻');

	$newsid = $db->insert('news',$info);

	if($info['is_transfor'] == 1){
		$video = array();
		$video_url = speech($newsid,$info['content']);
		$video['audio_url'] = URL_PATH.$video_url;
		$db->update('news',$video,"id='{$newsid}'");
	}

	unset($_SESSION['image1'],$_SESSION['image2'],$_SESSION['image3']);

	$aid  = $_SESSION['admin_id'];
	$text = '添加新闻，添加新闻ID：' . $newsid;
	operate_log($aid, 'news', 1, $text);
	
	$url_to = "news.php?action=list";
	url_locate($url_to, '添加成功');	
}

/*------------------------------------------------------ */
//-- 修改新闻
/*------------------------------------------------------ */	
function mod_news()
{
	global $db, $smarty;
	
	$id  = irequest('id');
	$sql = "SELECT * FROM news WHERE id = '{$id}'";
	$row = $db->get_row($sql);

	$smarty->assign('news', $row);
	
	$now_page = irequest('now_page');
	$smarty->assign('now_page', $now_page);

	$lables = get_lables();
	foreach($lables as $key=>$val){
		if(strstr("{$row['lables']}","{$val['id']}")){
			$lables[$key]['flg'] = 1;
		}
	}

	//新闻分类
	$smarty->assign('news_category',  get_news_category());
	$smarty->assign('vote',  get_vote());
	$smarty->assign('lables',  $lables);
	
	$smarty->assign('action', 'do_mod_news');
	$smarty->assign('page_title', '修改新闻');
	$smarty->display('news/news.htm');
}

/*------------------------------------------------------ */
//-- 修改新闻
/*------------------------------------------------------ */	
function do_mod_news()
{
	global $db;
	$info = $_POST['info'];
	$lables = $_POST['lables'];
	$info['lables'] = implode(',',$lables);
	check_null($info['title'], 			'标题');
	$id = irequest('id');
	if($info['is_transfor'] == 1){
		$video_url = speech($id,$info['content']);
		$info['audio_url'] = URL_PATH.$video_url;
	}
	$db->update('news',$info,"id='{$id}'");

	unset($_SESSION['image1'],$_SESSION['image2'],$_SESSION['image3']);
	$aid  = $_SESSION['admin_id'];
	$text = '修改新闻，修改新闻ID：' . $id;
	operate_log($aid, 'news', 2, $text);
	
	$now_page = irequest('now_page');
	$url_to = "news.php?action=list&page={$now_page}";
	url_locate($url_to, '修改成功');	
}

/*------------------------------------------------------ */
//-- 删除新闻
/*------------------------------------------------------ */	
function del_news()
{
	global $db;
	
	$id  = irequest('id');
	/*$sql = "SELECT cover FROM news WHERE id = '{$id}'";
	$row = $db->get_row($sql);
	del_img($row['cover']);*/
	
	/*$sql = "DELETE FROM news WHERE id = '{$id}'";
	$db->query($sql);*/

	$update_col = "is_delete = '1'";
	$sql = "UPDATE news SET {$update_col} WHERE id = '{$id}'";
	$db->query($sql);
	
	$aid  = $_SESSION['admin_id'];
	$text = '删除新闻，删除新闻ID：' . $id;
	operate_log($aid, 'news', 3, $text);
	
	$now_page = irequest('now_page');
	$url_to = "news.php?action=list&page={$now_page}";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 批量删除新闻
/*------------------------------------------------------ */	
function del_sel_news()
{
	global $db;
	$id = crequest('checkboxes');
	
	if ($id == '')
		alert_back('请选中需要删除的选项');
		
	/*$sql = "SELECT cover FROM news WHERE id IN ({$id})";
	$imgs_all = $db->get_all($sql);
	for ($i = 0; $i < count($imgs_all); $i++)
	{
		$cover = $imgs_all[$i]['cover'];
		del_img($cover);
	}*/

	$sql = "SELECT * FROM news WHERE id IN ({$id})";
	$news_all = $db->get_all($sql);
	$update_col = "is_delete = '1'";
	foreach($news_all as $key=>$val){
		$sql = "UPDATE news SET {$update_col} WHERE id = '{$val['id']}'";
		$db->query($sql);
	}
	
/*	$sql = "DELETE FROM news WHERE id IN ({$id})";
	$db->query($sql);*/
	
	$aid  = $_SESSION['admin_id'];
	$text = '批量删除新闻，批量删除新闻ID：' . $id;
	operate_log($aid, 'news', 4, $text);
	
	$now_page = irequest('now_page');
	$url_to = "news.php?action=list&page={$now_page}";
	href_locate($url_to);	
}

/*------------------------------------------------------ */
//-- 删除新闻图片
/*------------------------------------------------------ */	
function del_one_img()
{
	$img_name = crequest('img_name');
	//del_img($img_name);
	
	$id = irequest('id');
	$now_page = irequest('now_page');
	
	global $db;
	$replace_img = $img_name . '|';
	$sql = "UPDATE news SET imgs = replace(imgs, '{$replace_img}', '') WHERE id = '{$id}'";
	$db->query($sql);
	
	$url_to = "news.php?action=mod_news&id={$id}&now_page=$now_page";
	href_locate($url_to, '删除成功');	
}

/*------------------------------------------------------ */
//-- 新闻分类
/*------------------------------------------------------ */
function get_news_category()
{
	global $db;
	$adminid  = $_SESSION["admin_id"];
	
	$sql = "SELECT catid, catname FROM news_category WHERE pid = 0 and adminid='{$adminid}' ORDER BY listorder";
	$res = $db->get_all($sql);
	$num = count($res);
	
	for ($i = 0; $i < $num; $i++)
	{
		$catid  = $res[$i]['catid'];
		$sql = "SELECT catid, catname FROM news_category WHERE pid = {$catid} and adminid='{$adminid}' ORDER BY listorder";
		$res[$i]['sub'] = $db->get_all($sql);
	}
	
	return $res;
}

function get_lables()
{
	global $db;
	$sql = "SELECT id,name FROM lable WHERE is_delete=0 ORDER BY listorder DESC";
	$res = $db->get_all($sql);
	return $res;
}

/*------------------------------------------------------ */
//-- 检查分类是否存在子分类
/*------------------------------------------------------ */
function checkChild()
{
	global $db;
	$adminid  = $_SESSION["admin_id"];
	$catid  = irequest('catid');
	$sql = "SELECT catid, catname FROM news_category WHERE pid = {$catid} and adminid='{$adminid}' ORDER BY listorder";
	$res = $db->get_all($sql);
	if(is_array($res) && $res){
		echo json_encode(1);
	}else{
		echo json_encode(0);
	}
	exit;
}

function get_vote()
{
	global $db;
	$adminid  = $_SESSION["admin_id"];
	$time = time();
	$sql = "SELECT id, title FROM vote WHERE adminid='{$adminid}' and end_time > '{$time}' and is_delete = 0  ORDER BY id DESC ";
	$vote = $db->get_all($sql);

	return $vote;
}

function speech($id,$content){
	//从数据库获取富文本string
	$string = $content;
    //把一些预定义的 HTML 实体转换为字符
	$html_string = htmlspecialchars_decode($string);
    //将空格替换成空
	$content = str_replace(" ", "", $html_string);
    //函数剥去字符串中的 HTML、XML 以及 PHP 的标签,获取纯文本内容
	$contents = strip_tags($content);

	//文字转语音
	$client = new AipSpeech(BD_APP_ID, BD_API_KEY, BD_SECRET_KEY);
	$result = $client->synthesis($contents, 'zh', 1, array('vol' => 5,));
	// 识别正确返回语音二进制 错误则返回json 参照下面错误码
	if(!is_array($result)){
		$newFile=$_SERVER['DOCUMENT_ROOT'].'/upload/mp3/'.$id.'_audio.mp3';
		file_put_contents('audio.mp3', $result);
		rename('audio.mp3',$newFile); //拷贝到新目录
	}
	return '/upload/mp3/'.$id.'_audio.mp3';
}
