<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>ch11-2-1.php</title>
</head>
<body>
<?php
$link = mysqli_connect(
   'mysql.railway.internal',
   'root',
   'KydGcOdIbdYezedVcyOEnkDdMPZMPexn',
   'myschool')
   or die('無法開啟 MySQL 資料庫連接!<br/>');

echo '資料庫myschool開啟成功!<br/>';
$sql = 'SELECT * FROM students';
echo 'SQL查詢字串: $sql <br/>';

// 送出查詢的SQL指令
if ( $result = mysqli_query($link, $sql) ) { 
   echo '<b>學生資料:</b><br/>';
   while( $row = mysqli_fetch_assoc($result) ){ 
      echo $row["sno"].'-'.$row["name"].'-'.$row["birthday"].'<br/>';
   }
   mysqli_free_result($result);
}
mysqli_close($link);
?>
</body>
</html>