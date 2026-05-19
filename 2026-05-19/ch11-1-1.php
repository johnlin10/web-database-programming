<?php
$title = 'ch11-1-1.php';
$date  = '2026-05-19';
$meta  = 'MySQL 資料庫連線測試';
ob_start();
?>
<?php
require __DIR__ . '/../db.php';
mysqli_report(MYSQLI_REPORT_OFF);
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, 'myschool');

if ( !$link ) {
   echo 'MySQL資料庫連接錯誤!<br/>';
} else {
   echo 'MySQL資料庫myschool連接成功!<br/>';
   mysqli_close($link);
}
?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../_layout.php';
