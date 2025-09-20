<?php

$filePath = 'resources/lang/hi/messages.php';
$backupPath = 'temps/messages_hi_backup.php';

if (!file_exists($filePath)) {
    echo "❌ Error: $filePath not found!\n";
    exit(1);
}

// Create backup
copy($filePath, $backupPath);
echo "💾 Backup created: $backupPath\n";

// Read the file content
$content = file_get_contents($filePath);

// Extract the PHP array content
$lines = file($filePath, FILE_IGNORE_NEW_LINES);
$seenKeys = [];
$newLines = [];
$insideArray = false;

foreach ($lines as $line) {
    // Check if we're starting the array
    if (preg_match('/^return \[/', $line)) {
        $insideArray = true;
        $newLines[] = $line;
        continue;
    }
    
    // Check if we're ending the array
    if (preg_match('/^\];?$/', $line)) {
        $insideArray = false;
        $newLines[] = $line;
        continue;
    }
    
    // If we're inside the array and this is a key line
    if ($insideArray && preg_match("/^\s*'([^']+)'\s*=>/", $line, $matches)) {
        $key = $matches[1];
        
        if (isset($seenKeys[$key])) {
            // Skip duplicate key
            echo "Removed duplicate: $key\n";
            continue;
        } else {
            // Mark key as seen
            $seenKeys[$key] = true;
            $newLines[] = $line;
        }
    } else {
        // For comments and other lines, just add them
        $newLines[] = $line;
    }
}

// Write the cleaned content back to the file
file_put_contents($filePath, implode("\n", $newLines) . "\n");

echo "\n📊 Statistics:\n";
echo "==============\n";
echo "🗑️  Total duplicates removed: " . (count($lines) - count($newLines)) . "\n";
echo "✅ Duplicate removal complete!\n";
echo "📁 Original file backed up to: $backupPath\n";
echo "🎯 Cleaned file saved to: $filePath\n";