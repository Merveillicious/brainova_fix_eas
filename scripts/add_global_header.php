<?php

$projectRoot = dirname(__DIR__);

$directories = [
    $projectRoot . '/resources/views/siswa',
    $projectRoot . '/resources/views/tutor',
    $projectRoot . '/resources/views/admin',
];

$headerHtml = <<<HTML
<header class="global-header">
    <div class="global-header-content">
        <div class="global-header-logo">
            <span class="logo-text">Brainova</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left:6px;"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
        </div>
    </div>
</header>
HTML;

function processDirectory($dir, $headerHtml) {
    if (!is_dir($dir)) return;
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($files as $file) {
        if ($file->isFile() && strpos($file->getFilename(), '.blade.php') !== false) {
            $content = file_get_contents($file->getPathname());
            // If the file has a <body> tag and doesn't already have the global-header
            if (strpos($content, '<body') !== false && strpos($content, 'class="global-header"') === false) {
                // Find <body> and insert the header after it
                $content = preg_replace('/(<body[^>]*>)/i', "$1\n" . $headerHtml, $content, 1);
                file_put_contents($file->getPathname(), $content);
                echo "Added header to: " . $file->getPathname() . "\n";
            }
        }
    }
}

foreach ($directories as $dir) {
    processDirectory($dir, $headerHtml);
}

$cssContent = <<<CSS

/* ── Global Header ── */
.global-header {
    width: 100%;
    background: #FBBF24;
    border-bottom: 2px solid #000;
    padding: 10px 24px;
    position: sticky;
    top: 0;
    z-index: 1000;
}
.global-header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.global-header-logo {
    font-size: 16px;
    font-weight: 800;
    color: #000;
    display: flex;
    align-items: center;
}
CSS;

$cssPath = $projectRoot . '/public/css/brainova.css';
if (strpos(file_get_contents($cssPath), '.global-header') === false) {
    file_put_contents($cssPath, "\n" . $cssContent, FILE_APPEND);
    echo "Added CSS to brainova.css\n";
}

echo "Done.\n";
