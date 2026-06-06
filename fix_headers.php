<?php

$directories = [
    __DIR__ . '/resources/views/siswa',
    __DIR__ . '/resources/views/tutor',
    __DIR__ . '/resources/views/admin',
];

$unifiedHeaderAdmin = <<<HTML
<header class="app-topbar">
    <a href="/admin/dashboard" class="app-brand">
        Brainova 
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
        </svg>
    </a>
    <div style="margin-left: auto; display: flex; align-items: center; gap: 12px;">
        <span class="badge-role">Admin</span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout">Log out</button>
        </form>
    </div>
</header>
HTML;

function getUnifiedHeaderSiswaTutor($dir) {
    $dashboardRoute = strpos($dir, 'siswa') !== false ? "siswa.dashboard" : "tutor.dashboard";
    return <<<HTML
<header class="app-topbar">
    <a href="{{ route('$dashboardRoute') }}" class="app-brand">
        Brainova 
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
        </svg>
    </a>
</header>
HTML;
}

function cleanFileContent($content) {
    // Remove global-header
    $content = preg_replace('/<header class="global-header">.*?<\/header>\s*/s', '', $content);
    // Remove old app-topbar
    $content = preg_replace('/<div class="app-topbar">.*?<\/div>\s*/s', '', $content);
    // Remove admin navbar
    $content = preg_replace('/<nav class="navbar">.*?<\/nav>\s*/s', '', $content);
    // Remove any newly added app-topbar (if run multiple times)
    $content = preg_replace('/<header class="app-topbar">.*?<\/header>\s*/s', '', $content);
    return $content;
}

function processDirectory($dir, $unifiedHeaderAdmin) {
    if (!is_dir($dir)) return;
    $isAdmin = (strpos($dir, 'admin') !== false);
    
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($files as $file) {
        if ($file->isFile() && strpos($file->getFilename(), '.blade.php') !== false) {
            $content = file_get_contents($file->getPathname());
            $content = cleanFileContent($content);
            
            $headerHtml = $isAdmin ? $unifiedHeaderAdmin : getUnifiedHeaderSiswaTutor($dir);
            
            // Insert after <body>
            if (strpos($content, '<body') !== false) {
                $content = preg_replace('/(<body[^>]*>)/i', "$1\n" . $headerHtml, $content, 1);
            }
            
            // Fix height of chat wrappers if needed
            $content = str_replace('height: calc(100vh - 44px);', 'height: calc(100vh - 70px);', $content); // app-topbar is ~70px
            $content = str_replace('height: 100vh;', 'height: calc(100vh - 70px);', $content);
            
            file_put_contents($file->getPathname(), $content);
            echo "Updated header in: " . $file->getPathname() . "\n";
        }
    }
}

foreach ($directories as $dir) {
    processDirectory($dir, $unifiedHeaderAdmin);
}

echo "Done.\n";
