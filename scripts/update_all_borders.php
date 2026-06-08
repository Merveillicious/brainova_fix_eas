<?php
$projectRoot = dirname(__DIR__);
$dirs = [
    $projectRoot . '/public/css',
    $projectRoot . '/resources/views/siswa',
    $projectRoot . '/resources/views/tutor',
];

function processDir($dir) {
    if(!is_dir($dir)) return;
    $files = scandir($dir);
    foreach($files as $file) {
        if($file === '.' || $file === '..') continue;
        $path = $dir . '/' . $file;
        if(is_dir($path)) {
            processDir($path);
        } else {
            if(pathinfo($path, PATHINFO_EXTENSION) === 'php' || pathinfo($path, PATHINFO_EXTENSION) === 'css') {
                $content = file_get_contents($path);
                
                // Replace any border definition that isn't 2px solid #000, specifically looking for thin borders
                // Example: border: 1px solid #e5e7eb; -> border: 2px solid #000;
                $pattern1 = '/border:\s*1(?:\.5)?px\s+solid\s+#[a-fA-F0-9]{3,6};?/i';
                $pattern2 = '/border-bottom:\s*1(?:\.5)?px\s+solid\s+#[a-fA-F0-9]{3,6};?/i';
                $pattern3 = '/border-top:\s*1(?:\.5)?px\s+solid\s+#[a-fA-F0-9]{3,6};?/i';
                $pattern4 = '/border-right:\s*1(?:\.5)?px\s+solid\s+#[a-fA-F0-9]{3,6};?/i';
                $pattern5 = '/border-left:\s*1(?:\.5)?px\s+solid\s+#[a-fA-F0-9]{3,6};?/i';
                
                $newContent = preg_replace($pattern1, 'border: 2px solid #000;', $content);
                $newContent = preg_replace($pattern2, 'border-bottom: 2px solid #000;', $newContent);
                $newContent = preg_replace($pattern3, 'border-top: 2px solid #000;', $newContent);
                $newContent = preg_replace($pattern4, 'border-right: 2px solid #000;', $newContent);
                $newContent = preg_replace($pattern5, 'border-left: 2px solid #000;', $newContent);

                if ($content !== $newContent) {
                    file_put_contents($path, $newContent);
                    echo "Updated: $path\n";
                }
            }
        }
    }
}

foreach($dirs as $dir) {
    processDir($dir);
}
echo "Done.";
