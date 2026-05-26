<?php
session_start();

// 檢查 Session 變數是否存在，表示是否已成功登入
if ($_SESSION["login_session"] != true) {
    header("Location: login.php");  // 未登入則轉回登入頁
    exit();
}

// 取出使用者名稱後再銷毀 Session
$welcome_user = $_SESSION["username"];
session_destroy();

// 套用共用版型 
$title  = '課堂練習 12：登入成功';
$date   = '2026-05-26';
$meta   = '使用 Session 實作登入驗證，成功後顯示使用者姓名';
ob_start();
?>
<p>歡迎 <span class="highlight"><?= htmlspecialchars($welcome_user) ?></span> 進入網站！</p>
<hr>
<a class="back" href="login.php"><i data-lucide="arrow-left"></i> 返回登入頁</a>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../_layout.php';
