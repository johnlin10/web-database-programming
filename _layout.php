<?php
/* ════════════════════════════════════════════════════════════════════════
   _layout.php — 作業共用外框
   ════════════════════════════════════════════════════════════════════════ */

/* ── 原始碼掃描 ─────────────────────────────────────────────────────────
   規則：
   ・直接在日期目錄下的 .php 檔  → 只顯示自己（各作業獨立）
   ・在日期目錄的子目錄中的 .php 檔 → 掃描同一子目錄（同一作業的多個檔案）
   ──────────────────────────────────────────────────────────────────── */
$__srcFiles   = [];
$__srcDateDir = null;
$__s = realpath($_SERVER['SCRIPT_FILENAME'] ?? '');

if ($__s && preg_match('#^(.*?/20\d{2}-\d{2}-\d{2})(?=/|$)#', $__s, $__m)) {
    $__srcDateDir = $__m[1];
    $__scriptDir  = dirname($__s);

    if ($__scriptDir === $__srcDateDir) {
        // 直接在日期目錄下 → 只顯示當前檔案
        $__srcFiles = [$__s];
    } else {
        // 在子目錄中 → 掃描同一子目錄的所有 .php 檔
        $__tmp = glob($__scriptDir . '/*.php') ?: [];
        sort($__tmp);
        $__srcFiles = $__tmp;
        // 讓當前腳本排在第一位
        $__ci = array_search($__s, $__srcFiles);
        if ($__ci !== false && $__ci > 0) {
            array_splice($__srcFiles, $__ci, 1);
            array_unshift($__srcFiles, $__s);
        }
        unset($__tmp, $__ci);
    }
    unset($__m, $__scriptDir);
}
unset($__s);
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?= htmlspecialchars($title) ?> | 網頁資料庫程式設計</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
svg.lucide { width: 1em; height: 1em; vertical-align: -0.125em; }
body {
  background: #0e0e0e;
  color: #c0c0c0;
  font-family: 'SF Mono', 'Menlo', 'Consolas', monospace;
  min-height: 100vh;
  padding: 56px 24px;
}
.page { max-width: 680px; margin: 0 auto; }
.header {
  margin-bottom: 40px;
  padding-bottom: 24px;
  border-bottom: 1px solid #1e1e1e;
}
.back {
  font-size: 0.72rem;
  color: #383838;
  text-decoration: none;
  letter-spacing: 0.06em;
  display: inline-block;
  margin-bottom: 20px;
  transition: color 0.15s;
}
.back:hover { color: #666; }
.header h1 {
  font-size: 1.15rem;
  font-weight: 400;
  color: #e0e0e0;
  letter-spacing: 0.04em;
}
.header .meta {
  margin-top: 8px;
  font-size: 0.7rem;
  color: #333;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  display: flex;
  align-items: center;
  gap: 12px;
}
.source-link {
  color:#0f3457;
  text-decoration: none;
  transition: color 0.15s;
}
.source-link:hover { color:rgb(17, 72, 122); }

/* ── 視窗通用框 ── */
.window {
  border: 1px solid #1e1e1e;
  border-radius: 5px;
  overflow: hidden;
}
.window-bar {
  background: #141414;
  border-bottom: 1px solid #1e1e1e;
  padding: 9px 16px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.dots { display: flex; gap: 5px; }
.dots span { width: 9px; height: 9px; border-radius: 50%; background: #252525; }
.window-label {
  font-size: 0.68rem;
  color: #333;
  letter-spacing: 0.1em;
  text-transform: uppercase;
}
.window-body {
  background: #0e0e0e;
  padding: 28px 24px;
  font-size: 0.82rem;
  line-height: 1.8;
  color: #909090;
}
.window-body hr {
  border: none;
  border-top: 1px solid #1e1e1e;
  margin: 9px 0;
}
.window-body button {
  background: #141414;
  color: #888;
  border: 1px solid #ffffff2a;
  border-radius: 4px;
  width: fit-content;
  margin: 9px 0;
  margin-right: 6px;
  padding: 6px 14px;
  font-family: inherit;
  font-size: 0.78rem;
  letter-spacing: 0.06em;
  cursor: pointer;
}
.window-body button:hover {
  color: #d0d0d0;
  border-color: #ffffff35;
}

/* ── 原始碼視窗 ── */
.source-window {
  margin-bottom: 16px;
}
/* 單一檔案：在標題列右側顯示路徑 */
.src-single-label {
  font-size: 0.65rem;
  color: #2e2e2e;
  letter-spacing: 0.04em;
}
/* 多檔案：標籤列 */
.src-tabs-nav {
  display: flex;
  flex: 1;
  overflow-x: auto;
  gap: 2px;
  scrollbar-width: none;
  margin: 0 -4px; /* 讓最後一個 tab 不留右 padding */
}
.src-tabs-nav::-webkit-scrollbar { display: none; }
.src-tab {
  background: transparent;
  border: none;
  color: #313131;
  cursor: pointer;
  font-family: inherit;
  font-size: 0.65rem;
  letter-spacing: 0.04em;
  padding: 4px 10px;
  border-radius: 3px;
  white-space: nowrap;
  transition: color 0.15s, background-color 0.15s;
}
.src-tab:hover  { color: #666; background: rgba(255,255,255,0.03); }
.src-tab.active { color: #aaa; background: rgba(255,255,255,0.06); }
/* 程式碼內容區 */
.source-body {
  background: #0a0a0a;
  overflow: auto;
  max-height: 420px;
}
.src-pane          { display: none; }
.src-pane.active   { display: block; }
.source-body pre   { margin: 0; }
/* 覆蓋 highlight.js atom-one-dark 的背景色，融入我們的深色主題 */
.source-body pre code.hljs {
  background: #0a0a0a !important;
  font-family: 'SF Mono', 'Menlo', 'Consolas', monospace !important;
  font-size: 0.76rem !important;
  line-height: 1.65 !important;
  padding: 20px 24px !important;
  tab-size: 4;
}

/* ── 表單控件（供各作業共用） ── */
.submit-btn {
  background: #314170ff !important;
}
.submit-btn:hover {
  background: #334888ff !important;
}
.form { display: flex; flex-direction: column; gap: 12px; }
.form-row { display: flex; align-items: center; gap: 10px; }
.form-label { width: 100px; font-size: 0.78rem; color: #555; flex-shrink: 0; }
.form-input {
  flex: 1;
  background: #141414;
  border: 1px solid #2a2a2a;
  border-radius: 4px;
  padding: 6px 10px;
  color: #c0c0c0;
  font-family: inherit;
  font-size: 0.82rem;
}
.form-input:focus { outline: none; border-color: #404040; }
/* ── 輔助文字 ── */
.error-msg    { color: #e05555; font-size: 0.78rem; }
.hint         { font-size: 0.72rem; color: #333; letter-spacing: 0.04em; }
.highlight    { color: #e0e0e0; font-weight: 600; }
.required-mark { color: #e05555; margin-left: 2px; }
</style>
<?php if (!empty($styles)): ?>
<style><?= $styles ?></style>
<?php endif; ?>
</head>
<body>
<div class="page">
  <header class="header">
    <a class="back" href="/"><i data-lucide="arrow-left"></i> 作業列表</a>
    <h1><?= htmlspecialchars($title) ?></h1>
    <div class="meta">
      <span><?= htmlspecialchars($date ?? '') ?><?= isset($meta) ? ' &nbsp;/&nbsp; ' . htmlspecialchars($meta) : '' ?></span>
      <a class="source-link" href="https://github.com/johnlin10/web-database-programming/blob/main<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" target="_blank" rel="noopener">SOURCE <i data-lucide="arrow-up-right"></i></a>
    </div>
  </header>

  <?php if (!empty($__srcFiles)): ?>
  <!-- ── 原始碼視窗 ─────────────────────────────────────────────────── -->
  <div class="window source-window">
    <div class="window-bar">
      <div class="dots"><span></span><span></span><span></span></div>
      <?php if (count($__srcFiles) === 1): ?>
        <span class="window-label">Source</span>
        <span class="src-single-label"><?= htmlspecialchars(substr($__srcFiles[0], strlen($__srcDateDir))) ?></span>
      <?php else: ?>
        <nav class="src-tabs-nav" role="tablist">
          <?php foreach ($__srcFiles as $__i => $__sf): ?>
          <button
            class="src-tab<?= $__i === 0 ? ' active' : '' ?>"
            role="tab"
            aria-selected="<?= $__i === 0 ? 'true' : 'false' ?>"
            aria-controls="src-pane-<?= $__i ?>"
            data-pane="src-pane-<?= $__i ?>"
          ><?= htmlspecialchars(substr($__sf, strlen($__srcDateDir))) ?></button>
          <?php endforeach; ?>
        </nav>
      <?php endif; ?>
    </div>
    <div class="source-body">
      <?php foreach ($__srcFiles as $__i => $__sf): ?>
      <div
        class="src-pane<?= $__i === 0 ? ' active' : '' ?>"
        id="src-pane-<?= $__i ?>"
        role="tabpanel"
      ><pre><code class="language-php"><?php
          $__code = @file_get_contents($__sf);
          echo htmlspecialchars($__code !== false ? $__code : '// (無法讀取檔案)');
          unset($__code);
        ?></code></pre></div>
      <?php endforeach; ?>
    </div>
  </div>
  <?php unset($__i, $__sf); ?>
  <?php endif; ?>

  <!-- ── Output 視窗 ───────────────────────────────────────────────── -->
  <div class="window">
    <div class="window-bar">
      <div class="dots"><span></span><span></span><span></span></div>
      <span class="window-label">Output</span>
    </div>
    <div class="window-body"><?= $content ?></div>
  </div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script>
hljs.highlightAll();
lucide.createIcons();

/* ── 原始碼標籤分頁切換 ── */
document.querySelectorAll('.src-tab').forEach(function (btn) {
  btn.addEventListener('click', function () {
    var paneId = this.dataset.pane;
    var nav    = this.closest('.src-tabs-nav');
    var body   = this.closest('.window').querySelector('.source-body');

    nav.querySelectorAll('.src-tab').forEach(function (b) {
      b.classList.remove('active');
      b.setAttribute('aria-selected', 'false');
    });
    body.querySelectorAll('.src-pane').forEach(function (p) {
      p.classList.remove('active');
    });

    this.classList.add('active');
    this.setAttribute('aria-selected', 'true');
    document.getElementById(paneId).classList.add('active');
  });
});
</script>
</body>
</html>
