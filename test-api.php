<?php
// Test if /api/auth.php is accessible as JSON

// Try to access the API
$url = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/api/auth.php?action=me';

echo "Testing API endpoint: $url\n\n";

// Use curl if available
if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "HTTP Status: $httpCode\n\n";
    
    // Check if response is JSON or HTML
    $lines = explode("\n", $response);
    $lastLine = trim(end($lines));
    
    if (strpos($lastLine, '{') === 0) {
        echo "✓ API returns JSON:\n";
        echo $lastLine . "\n";
    } else {
        echo "✗ API returns HTML (likely .htaccess issue):\n";
        echo substr($lastLine, 0, 200) . "...\n";
        echo "\nThis means .htaccess is rewriting /api/ calls to index.php\n";
    }
} else {
    echo "curl not available. Test manually:\n";
    echo "  1. Open DevTools (F12) → Network\n";
    echo "  2. Go to: {$url}\n";
    echo "  3. Check if response is JSON or HTML\n";
}
?>
