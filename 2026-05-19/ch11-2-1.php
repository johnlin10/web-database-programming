<?php
$title = '課堂練習 11：MySQL 資料查詢';
$date  = '2026-05-19';
$meta  = '查詢 myschool 資料庫的 students 資料表並輸出所有記錄';
ob_start();
?>
<?php
require __DIR__ . '/../db.php';
mysqli_report(MYSQLI_REPORT_OFF);
$link = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, 'myschool');

if ( !$link ) {
   echo '無法開啟 MySQL 資料庫連接!<br/>';
} else {
   echo '資料庫 myschool 開啟成功!<br/>';
   $sql = 'SELECT * FROM students';
   echo "SQL 查詢字串: $sql <br/>";

   if ( $result = mysqli_query($link, $sql) ) {
      echo '<b>學生資料:</b><br/>';
      while( $row = mysqli_fetch_assoc($result) ){
         echo $row["sno"].'-'.$row["name"].'-'.$row["birthday"].'<br/>';
      }
      mysqli_free_result($result);
   }
   mysqli_close($link);
}
?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../_layout.php';
