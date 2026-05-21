<?php
$title = '課堂練習 6：計算 BMI';
$date  = '2026-03-24';
$meta  = '建立 BMI() 函數，以身高（公尺）與體重（公斤）計算 BMI 值';
ob_start();

function BMI($height, $weight) {
    return $weight / ($height * $height);
}

$result = null;
$weight = '';
$height = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $weight = $_POST['weight'] ?? '';
    $height = $_POST['height'] ?? '';
    if (is_numeric($weight) && is_numeric($height) && (float)$height > 0) {
        $result = BMI((float)$height, (float)$weight);
    }
}
?>
<style>
.form-row { margin-bottom: 12px; display: flex; align-items: center; gap: 10px; }
.form-row label { width: 7em; color: #888; flex-shrink: 0; }
.form-row input[type="number"] {
  background: #141414;
  color: #c0c0c0;
  border: 1px solid #2a2a2a;
  border-radius: 4px;
  padding: 5px 9px;
  font-family: inherit;
  font-size: 0.82rem;
  width: 120px;
  outline: none;
  transition: border-color 0.15s;
}
.form-row input[type="number"]:focus { border-color: #444; }
.unit { font-size: 0.75rem; color: #555; }
.bmi-result {
  margin-top: 18px;
  padding-top: 14px;
  border-top: 1px solid #1e1e1e;
  color: #c0c0c0;
}
</style>
<form method="post">
  <div class="form-row">
    <label>體重</label>
    <input type="number" name="weight" step="0.1" min="0"
           value="<?= htmlspecialchars($weight) ?>" placeholder="60" required/>
    <span class="unit">公斤</span>
  </div>
  <div class="form-row">
    <label>身高</label>
    <input type="number" name="height" step="0.01" min="0"
           value="<?= htmlspecialchars($height) ?>" placeholder="1.60" required/>
    <span class="unit">公尺</span>
  </div>
  <div class="form-row" style="margin-top:16px;">
    <label></label>
    <button type="submit">計算 BMI</button>
  </div>
</form>
<?php if ($result !== null): ?>
<div class="bmi-result">
  體重=<?= htmlspecialchars($weight) ?>公斤，身高=<?= htmlspecialchars($height) ?>公尺的BMI=<?= $result ?>
</div>
<?php endif; ?>
<?php
$content = ob_get_clean();
include __DIR__ . '/../_layout.php';
