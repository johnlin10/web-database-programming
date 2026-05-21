<?php
$title = '課堂練習 9：檔案讀寫操作';
$date  = '2026-04-28';
$meta  = '以附加模式將文字寫入檔案，並讀取顯示完整內容';
ob_start();
?>
<?php
$file = __DIR__ . '/mybooks.txt';
$content_text = "這是一段新增內容\r\n";

// 清除檔案內容
if (isset($_GET['clear'])) {
   file_put_contents($file, '');
   header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
   exit;
}

// 新增文字到檔案
if (is_writeable($file)) {
   $fp = fopen($file, "a");
   fwrite($fp, $content_text);
   echo "<button onclick='location.reload()'>新增內容</button>";
   echo "<button onclick='location.href=\"?clear=1\"'>清除內容</button><br/>";
   fclose($fp);
} else {
   print "檔案開啟錯誤<br/>";
}

// 顯示檔案內容
if (file_exists($file)) {
   echo "<hr>";
   echo "<pre>";
   $num = readfile($file);
   echo "</pre><hr>";
   echo "檔案擁有: $num 個位元組";
} else {
   print "檔案不存在<br/>";
}
?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../_layout.php';
