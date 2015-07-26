<?php
if(isset($_GET['term']) && is_string($_GET['term'])){
	$term = $_GET['term'];

}else{
	$term = '';
}

$link = mysql_connect('localhost', 'wakamori', 'wakamoripass');
if(!$link){
	exit("データベースに接続できませんでした\n");
}
$chset = mysql_set_charset("utf8", $link);
if(!$chset){
	exit("文字コードの設定に失敗しました\n");
}
$db = mysql_select_db('wakamoriDB',$link);
if(!$db){
	exit("データベースの選択に失敗しました\n");
}

$words = array();
$term2 = str_replace("-","",$term);//'-'を削除	
if(is_numeric($term2)){
	$sql = "SELECT zip,addr1,addr2,addr3 FROM zipAll WHERE zip like '".$term2."%' limit 10;";
}else{
	$sql = "SELECT zip,addr1,addr2,addr3 FROM zipAll WHERE CONCAT(addr1,addr2,addr3) like '%".$term."%' limit 10;";
}

$result = mysql_query($sql);
while($row = mysql_fetch_assoc($result)){
	//echo $row['CONCAT(addr1,addr2,addr3)']."\n";
	//$zip = insertStr($row['zip'],3,"-");
	
	//$line = $zip.$row['addr1'].$row['addr2'].$row['addr3'];
	$line = $row['addr1'].$row['addr2'].$row['addr3'];
	array_push($words, $line);
}

header("Content-Type: application/json; charset=utf-8");
echo json_encode($words);

mysql_close($link);

function insertStr($text1, $num, $text2){
	return substr($text1, 0, $num).$text2.substr($text1, $num, strlen($text1));
}
?>