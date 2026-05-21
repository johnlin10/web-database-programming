# 🌐 網頁資料庫程式設計 (Web Database Programming)

[![Railway Deployment](https://img.shields.io/badge/Deploy-Railway-0B0D17?style=for-the-badge&logo=railway&logoColor=fff)](https://railway.app)
[![PHP Version](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=fff)](https://www.php.net)
[![Database](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=fff)](https://www.mysql.com)
[![Docker](https://img.shields.io/badge/Docker-Supported-2496ED?style=for-the-badge&logo=docker&logoColor=fff)](https://www.docker.com)

本專案是專為**中臺科技大學**「**網頁資料庫程式設計**」課程開發的作業與練習展示平台。透過引進現代化的雲端部署技術，本專案打破了傳統課堂評分在地理位置與硬體設備上的限制，實現了隨時隨地可供訪問的動態網頁資料庫系統。

---

## 專案變革與背景：從 XAMPP 到 Railway

### 🔴 傳統評分方式的痛點 (XAMPP)

以往課堂上的評分方式是利用學生電腦運行 **XAMPP 軟體伺服器**，並在**學校區域網路 (LAN)** 內供教師現場連線打分：

- 學生電腦必須一直處於開機且運行的狀態。
- 一旦關閉電腦或離開學校網路，網站便無法被訪問。
- 教師無法在課後或遠端進行評分與指導。

### 🟢 雲端部署解決方案 (Railway)

為了解決上述問題，本專案花費了兩堂課的時間進行技術調研與實踐，最終捨棄了傳統的區域網 XAMPP 架構，選擇了現代雲端容器託管服務 **Railway**：

- **持續在線 (24/7 Available)**：網站部署於雲端，隨時隨地透過專屬網址皆能訪問。
- **資料庫雲端化**：利用 Railway 的 MySQL 服務，資料庫與網頁伺服器完美互連。
- **自動化部署**：透過 Git 聯動，每次推動（Push）代碼至 GitHub 時，Railway 會透過專屬的 `Dockerfile` 自動建置並即時更新部署。

---

## 專案特點

- **極簡終端風格 UI**：主頁與作業佈局採用極具質感的暗黑 Mono 字體風格，模擬開發者熟悉的 Terminal 終端視窗，給人專業、沉浸的視覺感受。
- **動態作業索引系統**：`index.php` 會自動掃描目錄下所有符合 `20*`（日期格式）的資料夾，並動態生成每次上課的作業選單，無需手動修改首頁程式碼。
- **統一輸出版面 (`_layout.php`)**：各項作業皆導入了統一的 Layout 包裝，包含導航、Github 原始碼連結以及仿 macOS 視窗的 Output 輸出區塊。
- **雙模資料庫連接設計 (`db.php`)**：
  - **本地端**：自動讀取 `.env` 環境變數檔，對接本地 MySQL。
  - **雲端環境**：自動偵測 Railway 注入的 `MYSQLHOST`、`MYSQLUSER`、`MYSQLPASSWORD` 等環境變數，實現零改動直接運行。

---

## 📂 專案目錄結構

```text
.
├── 2026-04-28/             # 2026-04-28 課堂練習與作業
│   ├── ch9-1-2.php         # 實作檔案
│   ├── ch9-2-3.php
│   └── mybooks.txt
├── 2026-05-19/             # 2026-05-19 課堂練習與作業
│   ├── ch11-1-1.php
│   ├── ch11-2-1.php        # 配合 MySQL 的學生資料查詢實作
│   └── myschool.sql        # 本次作業對應的 SQL 資料表結構定義
├── .env                    # 本地環境變數設定檔 (已加入 .gitignore)
├── .gitignore              # 排除無需提交的檔案 (課程範例、.env、系統檔)
├── _layout.php             # 統一外觀模板 (包含標題、日期、Github 原始碼連結)
├── db.php                  # 資料庫連線配置核心 (相容本地與 Railway 雲端環境)
├── Dockerfile              # Railway 部署所需的容器化設定
└── index.php               # 平台首頁 (動態載入並列出所有日期的作業)
```

---

## 🛠️ 技術細節與運作原理

### 1. 容器化部署 (`Dockerfile`)

專案採用輕量級的 `php:8.2-cli` 映像檔，並在構建時動態安裝 `mysqli` 擴充套件，確保 PHP 程式能與 MySQL 資料庫暢通連線：

```dockerfile
FROM php:8.2-cli
RUN docker-php-ext-install mysqli
WORKDIR /var/www/html
COPY . .
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-80} -t /var/www/html"]
```

### 2. 相容雙環境的資料庫橋接 (`db.php`)

我們在 `db.php` 中撰寫了智慧解析器。在**本地環境**下，它會自動讀取並解析 `.env` 檔案；而在 **Railway 雲端環境**中，則會直接調用 Railway 注入的全域變數：

```php
<?php
// 本地開發時，讀取並載入 .env 檔案
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#')) continue;
        [$key, $val] = explode('=', $line, 2) + [1 => ''];
        putenv(trim($key) . '=' . trim($val));
    }
}

// 優先調用雲端環境變數，若無則降級為本地預設值
define('DB_HOST', getenv('MYSQLHOST')     ?: 'localhost');
define('DB_USER', getenv('MYSQLUSER')     ?: 'root');
define('DB_PASS', getenv('MYSQLPASSWORD') ?: '');
```

---

## 💻 本地端快速啟動

如果你想在自己的電腦上運行此專案，請按照以下步驟操作：

### 步驟 1：複製專案

```bash
git clone https://github.com/johnlin10/web-database-programming.git
cd web-database-programming
```

### 步驟 2：設定資料庫與環境變數

在專案根目錄下建立 `.env` 檔案，並填入你的本地 MySQL 連線資訊：

```ini
MYSQLHOST=localhost
MYSQLUSER=root
MYSQLPASSWORD=你的資料庫密碼
```

_(注意：`.env` 已在 `.gitignore` 中設定忽略，不會被提交上網，確保密碼安全)_

### 步驟 3：匯入資料表

進入你的本地 MySQL 資料庫（如使用 phpMyAdmin 或 Navicat），建立對應的資料庫（例如 `myschool`），並將作業資料夾（如 `2026-05-19/myschool.sql`）中的 SQL 檔案匯入。

### 步驟 4：啟動 PHP 內建伺服器

在專案根目錄執行以下指令：

```bash
php -S localhost:8000
```

現在打開瀏覽器並訪問 `http://localhost:8000` 即可看見精美的首頁與作業列表！

---

## 開發者資訊

- **學校**：中臺科技大學 (CTUST)
- **課程**：網頁資料庫程式設計 (114-2)
- **學號**：F11308063
- **姓名**：林昌龍 (John Lin)
- **Github**：[@johnlin10](https://github.com/johnlin10)

---

_本專案由林昌龍精心設計與開發，旨在利用現代化雲端運算技術優化課堂學習體驗。_
