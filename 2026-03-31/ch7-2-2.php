<?php
$title = '課堂練習 7：結合陣列';
$date  = '2026-03-31';
$meta  = '以姓名為鍵保存學生成績';
ob_start();
?>
<?php
// 結合陣列 — 姓名為鍵，成績為值
$students = array(
    "林昌龍" => 95,
    "陳會安" => 80,
    "江小魚" => 75,
);

foreach ($students as $name => $score) {
    echo "$name 成績 $score<br/>";
}
?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../_layout.php';
