<?php
session_start();

// 載入資料庫連線設定（使用專案共用的 db.php，不再寫死密碼）
require __DIR__ . '/../../db.php';

$username  = "";
$password  = "";
$error_msg = "";

// 取得表單欄位值
if (isset($_POST["Username"])) $username = $_POST["Username"];
if (isset($_POST["Password"])) $password = $_POST["Password"];

// 檢查是否輸入使用者名稱和密碼
if ($username != "" && $password != "") {
    // 建立 MySQL 資料庫連接（使用 db.php 提供的常數，移除寫死密碼 A12345678）
    mysqli_report(MYSQLI_REPORT_OFF);
    $link = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, "myschool");

    if (!$link) {
        $error_msg = "無法開啟 MySQL 資料庫連接!";
    } else {
        // 建立 SQL 指令字串
        $sql  = "SELECT * FROM students WHERE password='";
        $sql .= $password . "' AND username='" . $username . "'";
        // 執行 SQL 查詢
        $result        = mysqli_query($link, $sql);
        $total_records = mysqli_num_rows($result);

        if ($total_records > 0) {
            // 成功登入，指定 Session 變數
            $_SESSION["login_session"] = true;
            $_SESSION["username"]      = $username;  // 儲存使用者名稱以供歡迎頁使用
            mysqli_close($link);
            header("Location: index.php");  // 轉跳至歡迎頁
            exit();
        } else {
            // 登入失敗
            $error_msg                 = "使用者名稱或密碼錯誤!";
            $_SESSION["login_session"] = false;
            mysqli_close($link);
        }
    }
}

// 套用共用版型
$title  = '課堂練習 12：網站登入系統';
$date   = '2026-05-26';
$meta   = '使用 Session 實作登入驗證，成功後顯示使用者姓名';
$styles = '.login-form { max-width: 280px; }';  // 此登入頁面專屬：限制表單寬度
ob_start();
?>
<form class="form login-form" action="login.php" method="post">
  <div class="form-row">
    <label class="form-label">使用者名稱<span class="required-mark">*</span></label>
    <input class="form-input" type="text" name="Username" maxlength="10" required />
  </div>
  <div class="form-row">
    <label class="form-label">使用者密碼<span class="required-mark">*</span></label>
    <input class="form-input" type="password" name="Password" maxlength="10" required />
  </div>
  <?php if ($error_msg): ?>
  <p class="error-msg"><?= htmlspecialchars($error_msg) ?></p>
  <?php endif; ?>
  <button class="submit-btn" type="submit">登入網站</button>
</form>
<hr>
<p class="hint">可用帳號：hueyan / smallfish / jay / jolin / chiang &nbsp;（密碼均為 1234）</p>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../_layout.php';
