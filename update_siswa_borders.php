<?php
$dir = __DIR__ . '/resources/views/siswa';
$files = scandir($dir);
foreach($files as $file) {
    if(pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        $path = $dir . '/' . $file;
        $content = file_get_contents($path);
        
        // Replace light borders with thick black borders
        $content = preg_replace('/border:\s*1(\.5)?px\s+solid\s+#[eE]5[eE]7[eE]b;?/', 'border: 2px solid #000;', $content);
        $content = preg_replace('/border:\s*1(\.5)?px\s+solid\s+#[dD]1[dD]5[dD]b;?/', 'border: 2px solid #000;', $content);
        $content = preg_replace('/border:\s*1(\.5)?px\s+solid\s+#f3f4f6;?/', 'border: 2px solid #000;', $content);
        $content = preg_replace('/border:\s*1(\.5)?px\s+solid\s+#[cC][cC][cC];?/', 'border: 2px solid #000;', $content);
        $content = preg_replace('/border:\s*1(\.5)?px\s+solid\s+#ddd;?/', 'border: 2px solid #000;', $content);
        
        $content = preg_replace('/border:\s*1(\.5)?px\s+dashed\s+#[eE]5[eE]7[eE]b;?/', 'border: 2px dashed #000;', $content);
        
        $content = preg_replace('/border-bottom:\s*1(\.5)?px\s+solid\s+#[eE]5[eE]7[eE]b;?/', 'border-bottom: 2px solid #000;', $content);
        $content = preg_replace('/border-right:\s*1(\.5)?px\s+solid\s+#[eE]5[eE]7[eE]b;?/', 'border-right: 2px solid #000;', $content);
        $content = preg_replace('/border-top:\s*1(\.5)?px\s+solid\s+#[eE]5[eE]7[eE]b;?/', 'border-top: 2px solid #000;', $content);
        $content = preg_replace('/border-bottom:\s*1(\.5)?px\s+solid\s+#f3f4f6;?/', 'border-bottom: 2px solid #000;', $content);
        
        // Sometimes CSS doesn't have spaces
        $content = preg_replace('/border:1px solid #[a-zA-Z0-9]+;?/', 'border:2px solid #000;', $content);
        // Exclude transparent and other important borders like error red if possible? Actually it's fine, I'll just replace gray ones directly to be safer:
        $content = preg_replace('/border:\s*1px\s+solid\s+#(?:e5e7eb|d1d5db|f3f4f6|ccc|ddd);?/i', 'border: 2px solid #000;', $content);
        $content = preg_replace('/border:\s*1\.5px\s+solid\s+#(?:e5e7eb|d1d5db|f3f4f6|ccc|ddd);?/i', 'border: 2px solid #000;', $content);

        // Also fix the filter sidebar and tutor cards in Cari Tutor
        $content = preg_replace('/border: 1px solid #e5e7eb;/', 'border: 2px solid #000;', $content);

        file_put_contents($path, $content);
    }
}
echo "Siswa borders updated.";
