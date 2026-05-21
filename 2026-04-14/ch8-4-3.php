<?php
$title = '課堂練習 8：表單資料輸出';
$date  = '2026-04-14';
$meta  = '顯示提交的姓名、密碼、地址與電話資料';
ob_start();
?>
<?php
if (empty($_POST)) {
    echo "<span style='color:#383838;font-size:0.82rem;'>尚未填寫資料。</span><br/><br/>";
    echo "<a href='ch3-5-2.php' style='color:#555;font-size:0.78rem;letter-spacing:0.04em;text-decoration:none;border-bottom:1px solid #2a2a2a;padding-bottom:1px;'>→ 前往 ch3-5-2.php 填寫表單</a>";
} else {
    $username = htmlspecialchars($_POST['User'] ?? '');
    $password = htmlspecialchars($_POST['Pass'] ?? '');
    $address  = htmlspecialchars($_POST['Address'] ?? '');
    $type     = htmlspecialchars($_POST['Type'] ?? '');
    $phone    = htmlspecialchars($_POST['Phone'] ?? '');

    echo "姓名: " . $username . "<br/>";
    echo "密碼: " . $password . "<br/>";
    echo "地址: " . nl2br($address) . "<br/>";
    echo "種類: " . $type . "<br/>";
    echo "<hr/>";
    echo "<span style='font-size:0.68rem;color:#333;letter-spacing:0.1em;text-transform:uppercase;'>▎ 進階</span><br/>";
    echo "電話: " . $phone . "<br/>";
}
?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../_layout.php';
