<?php
$title = '課堂練習 8：表單必填驗證';
$date  = '2026-04-14';
$meta  = '設定姓名為必填欄位，並新增電話欄位（進階）';
ob_start();
?>
<style>
.form-row { margin-bottom: 12px; }
.form-row label { display: inline-block; width: 5em; color: #888; }
.form-row input[type="text"],
.form-row input[type="password"],
.form-row input[type="tel"],
.form-row textarea {
  background: #141414;
  color: #c0c0c0;
  border: 1px solid #2a2a2a;
  border-radius: 4px;
  padding: 5px 9px;
  font-family: inherit;
  font-size: 0.82rem;
  outline: none;
  transition: border-color 0.15s;
  vertical-align: top;
}
.form-row input:focus,
.form-row textarea:focus { border-color: #444; }
.required-mark { color: #c0392b; margin-left: 2px; }
.section-label {
  font-size: 0.68rem;
  color: #333;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  border-top: 1px solid #1a1a1a;
  padding-top: 14px;
  margin-top: 4px;
  margin-bottom: 14px;
}
.submit-btn {
  background: #314170ff !important;
}
.submit-btn:hover {
  background: #334888ff !important;
}
</style>
<form name="login" method="post" action="ch8-4-3.php">
  <div class="form-row">
    <label>姓名<span class="required-mark">*</span></label>
    <input type="text" name="User" size="18" required/>
  </div>
  <div class="form-row">
    <label>密碼</label>
    <input type="password" name="Pass" size="18"/>
  </div>
  <div class="form-row">
    <label>地址</label>
    <textarea name="Address" rows="4" cols="36"></textarea>
  </div>
  <input type="hidden" name="Type" value="Member"/>
  <div class="section-label">▎ 進階 — 電話欄位</div>
  <div class="form-row">
    <label>電話</label>
    <input type="tel" name="Phone" size="18" placeholder="例: 0912-345-678"/>
  </div>
  <div class="form-row" style="margin-top:18px;">
    <label></label>
    <button type="submit" class="submit-btn">註冊</button>
  </div>
</form>
<?php
$content = ob_get_clean();
include __DIR__ . '/../_layout.php';
