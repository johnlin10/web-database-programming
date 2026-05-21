<?php
$title = '課堂練習 6：計算平均及總和';
$date  = '2026-03-24';
$meta  = '建立 average() 與 sum() 函數計算學生成績';
ob_start();
?>
<?php
function average($scores) {
    return array_sum($scores) / count($scores);
}

function sum($scores) {
    return array_sum($scores);
}

$scores = array(77, 88, 66);

echo "平均值 " . average($scores) . "<br/>";
echo "總和 " . sum($scores) . "<br/>";
?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../_layout.php';
