<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?= htmlspecialchars($title) ?> | 網資程設</title>
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
}
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
  min-height: 100px;
}
</style>
</head>
<body>
<div class="page">
  <header class="header">
    <a class="back" href="/">← 作業列表</a>
    <h1><?= htmlspecialchars($title) ?></h1>
    <div class="meta"><?= htmlspecialchars($date ?? '') ?><?= isset($meta) ? ' &nbsp;/&nbsp; ' . htmlspecialchars($meta) : '' ?></div>
  </header>
  <div class="window">
    <div class="window-bar">
      <div class="dots"><span></span><span></span><span></span></div>
      <span class="window-label">Output</span>
    </div>
    <div class="window-body"><?= $content ?></div>
  </div>
</div>
</body>
</html>
