<?php

$projectRoot = dirname(__DIR__);

$directories = [
    $projectRoot . '/resources/views/auth',
];

function removeSvgFromHeader($dir) {
    if (!is_dir($dir)) return;
    
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($files as $file) {
        if ($file->isFile() && strpos($file->getFilename(), '.blade.php') !== false) {
            $content = file_get_contents($file->getPathname());
            
            // The exact SVG string with flexible whitespace just in case
            $pattern = '/\s*<svg width="24" height="24"[^>]*>.*?<\/svg>/s';
            
            $newContent = preg_replace($pattern, '', $content);
            
            if ($newContent !== $content) {
                file_put_contents($file->getPathname(), $newContent);
                echo "Removed icon from: " . $file->getPathname() . "\n";
            }
        }
    }
}

foreach ($directories as $dir) {
    removeSvgFromHeader($dir);
}

echo "Done.\n";
