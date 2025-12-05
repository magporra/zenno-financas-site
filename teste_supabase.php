<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>TESTE CONEXÃO SUPABASE</h2>";

// CONFIG
$SUPABASE_URL = "https://kdsuvlaeepwjzqnfvxxr.supabase.co";
$SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtkc3V2bGFlZXB3anpxbmZ2eHhyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxNTMwMTIsImV4cCI6MjA3MTcyOTAxMn0.iuOiaoqm3BhPyEMs6mtn2KlA2CIuYdnkcfmc36_Z8t8";

$email_test = "teste@gmail.com";
$encoded = urlencode('"' . $email_test . '"');

$url = "$SUPABASE_URL/rest/v1/admins?email=eq.$encoded&select=*";

echo "<p><b>URL usada:</b><br>$url</p>";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $SUPABASE_KEY",
    "Authorization: Bearer $SUPABASE_KEY",
    "Content-Type: application/json",
    "Accept: application/json"
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "<p><b>Código HTTP:</b> $http_code</p>";

if ($response === false) {
    echo "<p><b>Erro CURL:</b> " . curl_error($ch) . "</p>";
    exit;
}

echo "<h3>Resposta JSON:</h3>";
echo "<pre>$response</pre>";

$data = json_decode($response, true);

echo "<h3>Array decode:</h3>";
echo "<pre>";
var_dump($data);
echo "</pre>";
