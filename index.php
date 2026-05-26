<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>網路資料庫程式設計</title>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
  background: #0e0e0e;
  color: #c0c0c0;
  font-family: 'SF Mono', 'Menlo', 'Consolas', monospace;
  min-height: 100vh;
  padding: 56px 24px;
}
.page { max-width: 680px; margin: 0 auto; }
.header {
  margin-bottom: 48px;
  padding-bottom: 24px;
  border-bottom: 1px solid #1e1e1e;
}
.header h1 {
  font-size: 1.25rem;
  font-weight: 400;
  color: #e0e0e0;
  letter-spacing: 0.04em;
}
.header .sub {
  margin-top: 8px;
  font-size: 0.72rem;
  color: #383838;
  letter-spacing: 0.1em;
  text-transform: uppercase;
}
.section { margin-bottom: 32px; }
.window {
  border: 1px solid #202020;
  border-radius: 5px;
  overflow: hidden;
}
.window-bar {
  background: #141414;
  border-bottom: 1px solid #202020;
  padding: 9px 16px;
  display: flex;
  align-items: center;
  gap: 10px;
}
.dots { display: flex; gap: 5px; }
.dots span {
  width: 9px; height: 9px;
  border-radius: 50%;
  background: #2a2a2a;
}
.window-label {
  font-size: 0.68rem;
  color: #505050;
  letter-spacing: 0.1em;
  text-transform: uppercase;
}
.window-body {
  background: #0e0e0e;
  padding: 20px 24px;
}
.file-list { list-style: none; }
.file-list li {
  border-bottom: 1px solid #181818;
  padding: 10px 0;
}
.file-list li:last-child { border-bottom: none; }
.file-list a {
  color: #888;
  text-decoration: none;
  font-size: 0.82rem;
  letter-spacing: 0.02em;
  display: flex;
  flex-direction: column;
  gap: 3px;
}
.file-list a:hover { color: #d0d0d0; }
.file-list a:hover .file-title { color: #c1c1c1; }
.file-list a:hover .file-desc { color: #555; }
.file-title { color: #888; }
.file-desc {
  font-size: 0.7rem;
  color: #383838;
  letter-spacing: 0.02em;
}
</style>
</head>
<body>
<div class="page">
  <header class="header">
    <h1>網頁資料庫程式設計</h1>
    <div class="sub">中臺科技大學 &nbsp;/&nbsp; F11308063 &nbsp;/&nbsp; 林昌龍</div>
  </header>
  <?php
  $dirs = glob(__DIR__ . '/20*', GLOB_ONLYDIR);
  rsort($dirs);
  foreach ($dirs as $dir) {
    $date = basename($dir);
    $files = glob($dir . '/*.php') ?: [];
    foreach (glob($dir . '/*', GLOB_ONLYDIR) ?: [] as $subdir) {
      foreach (glob($subdir . '/*.php') ?: [] as $subfile) {
        if (basename($subfile) !== 'index.php') {
          $files[] = $subfile;
        }
      }
    }
    if (empty($files)) continue;
    echo "<div class='section'>";
    echo "<div class='window'>";
    echo "<div class='window-bar'><div class='dots'><span></span><span></span><span></span></div><span class='window-label'>$date</span></div>";
    echo "<div class='window-body'><ul class='file-list'>";
    foreach ($files as $file) {
      $filename = basename($file);
      // 計算從專案根目錄出發的相對路徑（支援子目錄）
      $relpath = substr($file, strlen(__DIR__) + 1);
      $src = file_get_contents($file);
      preg_match('/\$title\s*=\s*[\'"]([^\'"]+)[\'"]/', $src, $mt);
      preg_match('/\$meta\s*=\s*[\'"]([^\'"]+)[\'"]/', $src, $mm);
      $label = htmlspecialchars($mt[1] ?? $filename);
      $desc  = htmlspecialchars($mm[1] ?? '');
      echo "<li><a href='$relpath'>";
      echo "<span class='file-title'>$label</span>";
      if ($desc) echo "<span class='file-desc'>$desc</span>";
      echo "</a></li>";
    }
    echo "</ul></div></div></div>";
  }
  ?>
</div>
</body>
</html>
