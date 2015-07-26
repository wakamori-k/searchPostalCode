<html>
<head>
  <title>郵便番号検索</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">	
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/searchPostalCode.css" rel="stylesheet">

  <script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script type="text/javascript" src="./js/getMap.js"></script>

</head>
<body>
  <a href="index.html"><button type="button" class="btn">ホーム
   <span class="glyphicon glyphicon-home"></span>
 </button></a><br>

 <?php
 $param = $_GET['param'];
 $page_num = $_GET['page_num'];
 $view_num = $_GET['view_num'];
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

echo "検索ワード：".$param."<br><br>\n";

$param2 = str_replace("-","",$param);//'-'を削除
if(is_numeric($param2)){//数字のみ(郵便番号)
  $sql = "SELECT COUNT(*) FROM zipAll WHERE zip like '%".$param2."%';";
  $result = mysql_query($sql);
  $count_res = mysql_fetch_assoc($result);
    $count = $count_res['COUNT(*)'];//マッチしたデータ数

    $sql = "SELECT * FROM zipAll WHERE zip like '%".$param2."%' LIMIT ".(($page_num-1)*10).", 10;";
    $result = mysql_query($sql);
}else if(preg_match("/^[ァ-ヾ]+$/u",$param)){//カタカナのみ
    $param = str_replace("-","",$param);//'-'を削除
    $sql = "SELECT COUNT(*) FROM zipAll WHERE CONCAT(kana1,kana2,kana3) like '%".$param."%';";
    $result = mysql_query($sql);
    $count_res = mysql_fetch_assoc($result);
    $count = $count_res['COUNT(*)'];//マッチしたデータ数

    $sql = "SELECT * FROM zipAll WHERE CONCAT(kana1,kana2,kana3) like '%".$param."%' LIMIT ".(($page_num-1)*10).", 10;";
    $result = mysql_query($sql);
  }else{
    $param = str_replace("-","",$param);//'-'を削除
    $sql = "SELECT COUNT(*) FROM zipAll WHERE CONCAT(addr1,addr2,addr3) like '%".$param."%';";
    $result = mysql_query($sql);
    $count_res = mysql_fetch_assoc($result);
    $count = $count_res['COUNT(*)'];//マッチしたデータ数

    $sql = "SELECT * FROM zipAll WHERE CONCAT(addr1,addr2,addr3) like '%".$param."%' LIMIT ".(($page_num-1)*10).", 10;";
    $result = mysql_query($sql);
  }

  echo "<table class=\"table table-bordered\" id=\"TBL\" style=\"width:600px;\">";
  echo " <thead><tr><td>住所</td><td>郵便番号</td></tr></thead><tbody>";		

  while($row = mysql_fetch_assoc($result)){
    echo "<tr><th align=\"left\">";
    echo $row['addr1'];
    echo $row['addr2'];
    echo $row['addr3'];
    echo "</th><th align=\"left\">";
    echo insertStr($row['zip'],3,"-");
    echo "</th></tr>\n";
  }
  echo "</tbody></table><br>\n";


  echo "<footer><center>";
  if($page_num>1){
   echo "<a href=show.php?param=".$param."&page_num=".($page_num-1).">";
   echo "&lt";
   echo "</a>";
 }else{
  echo "&lt";
}

for($i=0;$i*10<$count;$i++){
	echo "<a href=show.php?param=".$param."&page_num=".($i+1).">".($i+1)." </a>";
}

if($page_num*10 < $count){
	echo "<a href=show.php?param=".$param."&page_num=".($page_num+1).">";
	echo "&gt";
	echo "</a>";
}else{
  echo "&gt";
}
echo "</center></footer>";
echo "<br>";
echo "全".$count."件";

mysql_close($link);
?>
<center>
  <p id="Mbox0">郵便番号をクリックしてください</p>
  <p id="map-canvas" style="width:600px;height:450px;"></p>
</center>
</body>

</html>

<?php

function insertStr($text1, $num, $text2){
  return substr($text1, 0, $num).$text2.substr($text1, $num, strlen($text1));
}

?>