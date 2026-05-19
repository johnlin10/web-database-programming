<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>網路資料庫程式設計 - 作業列表</title>
<style>
  body { font-family: sans-serif; max-width: 700px; margin: 40px auto; padding: 0 20px; }
  h1 { font-size: 1.4em; border-bottom: 2px solid #333; padding-bottom: 8px; }
  .date-section { margin: 20px 0; }
  .date-title { font-weight: bold; font-size: 1.1em; margin-bottom: 6px; }
  ul { margin: 4px 0; padding-left: 20px; }
  li { margin: 4px 0; }
  a { color: #0066cc; text-decoration: none; }
  a:hover { text-decoration: underline; }
</style>
</head>
<body>
<h1>網路資料庫程式設計 - 作業列表</h1>
<?php
$dirs = glob(__DIR__ . '/20*', GLOB_ONLYDIR);
rsort($dirs);
foreach ($dirs as $dir) {
    $date = basename($dir);
    $files = glob($dir . '/*.php');
    if (empty($files)) continue;
    echo "<div class='date-section'>";
    echo "<div class='date-title'>$date</div><ul>";
    foreach ($files as $file) {
        $filename = basename($file);
        echo "<li><a href='$date/$filename'>$filename</a></li>";
    }
    echo "</ul></div>";
}
?>
</body>
</html>
