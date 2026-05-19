<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>ch11-1-1.php</title>
</head>
<body>
<?php
$link = @mysqli_connect(
   'mysql.railway.internal',
   'root',
   'KydGcOdIbdYezedVcyOEnkDdMPZMPexn',
   'myschool');

if ( !$link ) {
   echo 'MySQL資料庫連接錯誤!<br/>';
   exit();
}
else {
   echo 'MySQL資料庫myschool連接成功!<br/>';
}
mysqli_close($link);
?>
</body>
</html>