<?php
$title = '課堂練習 9：時區與檔案資訊';
$date  = '2026-04-28';
$meta  = '顯示台灣時區的當前時間，並讀取目前檔案的屬性資訊';
ob_start();
?>
<?php
date_default_timezone_set("Asia/Taipei");
$now = time();
echo "目前時區: " . date_default_timezone_get() . "<br/>";
echo  date("Y/m/d H:i:s", $now) . " (Asia/Taipei)" . "<br/>";
echo  gmdate("Y/m/d H:i:s", $now) . " (UTC)";
echo "<hr/>";
$file = "ch9-1-2.php";
echo "檔案名稱: " . $file . "<br/>";
echo "檔案類型: " . filetype($file) . "<br/>";
echo "最後存取: " .
   date("Y/n/d H:i:s", fileatime($file)) . "<br/>";
echo "最後修改: " .
   date("Y/n/d H:i:s", filemtime($file)) . "<br/>";
echo "檔案大小: " . filesize($file) . " 位元組<br/>";
echo "是否是目錄: [" . is_dir($file) . "]<br/>";
echo "是否是檔案: [" . is_file($file) . "]<br/>";
echo "是否可讀: [" . is_readable($file) . "]<br/>";
echo "是否可寫: [" . is_writeable($file) . "]<br/>";
echo "是否是上傳檔案: [" . is_uploaded_file($file) . "]";
?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../_layout.php';
