<?php
$title = '課堂練習 11：MySQL 連線測試';
$date  = '2026-05-19';
$meta  = '以 mysqli 連線至 MySQL，測試資料庫連線狀態';
ob_start();
?>
<?php
require __DIR__ . '/../db.php';
mysqli_report(MYSQLI_REPORT_OFF);
$link = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, 'myschool');

if ( !$link ) {
   echo 'MySQL 資料庫連接錯誤！<br/>';
} else {
   echo 'MySQL 資料庫 myschool 連接成功！<br/>';
   mysqli_close($link);
}
?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../_layout.php';
