<?php
// ─────────────────────────────────────────────
//  Green API — WhatsApp message sender
//  Replace YOUR_INSTANCE_ID and YOUR_API_TOKEN
//  with your real credentials from green-api.com
// ─────────────────────────────────────────────

header('Content-Type: text/plain; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// ── YOUR CREDENTIALS ──────────────────────────
$instanceId = 'YOUR_INSTANCE_ID';   // e.g. 1234567890
$apiToken   = 'YOUR_API_TOKEN';     // e.g. abc123xyz...
// ─────────────────────────────────────────────

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'error';
    exit;
}

// Sanitize inputs
function clean($str) {
    return htmlspecialchars(strip_tags(trim($str)), ENT_QUOTES, 'UTF-8');
}

$name    = clean($_POST['name']    ?? '');
$email   = clean($_POST['email']   ?? '');
$brand   = clean($_POST['brand']   ?? '');
$message = clean($_POST['message'] ?? '');

if (!$name || !$email || !$brand || !$message) {
    http_response_code(400);
    echo 'error';
    exit;
}

// Build WhatsApp message text
$date = date('d M Y, H:i');
$text = "🔔 *New Portfolio Enquiry*\n\n"
      . "👤 *Name:* {$name}\n"
      . "📧 *Email:* {$email}\n"
      . "🏷️ *Brand:* {$brand}\n"
      . "💬 *Message:* {$message}\n\n"
      . "📅 *Sent:* {$date}";

// Green API endpoint
$url = "https://api.green-api.com/waInstance{$instanceId}/sendMessage/{$apiToken}";

$payload = json_encode([
    'chatId'  => '923097171127@c.us',
    'message' => $text,
]);

// Send via cURL
$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload),
    ],
    CURLOPT_TIMEOUT        => 15,
    CURLOPT_SSL_VERIFYPEER => true,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = curl_error($ch);
curl_close($ch);

if ($curlErr || $httpCode < 200 || $httpCode >= 300) {
    http_response_code(500);
    echo 'error';
    exit;
}

// Green API returns JSON with idMessage on success
$decoded = json_decode($response, true);
if (isset($decoded['idMessage'])) {
    echo 'ok';
} else {
    http_response_code(500);
    echo 'error';
}
