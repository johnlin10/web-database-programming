<?php
$title = '課堂練習 7：索引陣列';
$date  = '2026-03-31';
$meta  = '新增自己的姓名與成績';
ob_start();
?>
<?php
// 索引陣列 — 成績
$grades = array(78, 55, 69, 93);
$grades[2] = 65;   // 更改成績
$grades[] = 95;    // 新增自己的成績

// 索引陣列 — 姓名
$names[] = "江小魚";
$names[] = "陳允傑";
$names[] = "楊過";
$names[] = "陳會安";
$names[] = "林昌龍";  // 新增自己

// 顯示成績
for ($i = 0; $i < count($grades); $i++) {
    echo "$i=>{$grades[$i]} ";
}
echo "<br/>";

// 顯示姓名
for ($i = 0; $i < count($names); $i++) {
    echo "$i=>{$names[$i]} ";
}
echo "<br/>";
?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../_layout.php';
