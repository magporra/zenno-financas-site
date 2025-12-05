<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$SUPABASE_URL = "https://kdsuvlaeepwjzqnfvxxr.supabase.co";
$SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtkc3V2bGFlZXB3anpxbmZ2eHhyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxNTMwMTIsImV4cCI6MjA3MTcyOTAxMn0.iuOiaoqm3BhPyEMs6mtn2KlA2CIuYdnkcfmc36_Z8t8";

$url = "$SUPABASE_URL/rest/v1/admins?select=id,email";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $SUPABASE_KEY",
    "Authorization: Bearer $SUPABASE_KEY",
    "Content-Type: application/json",
    "Accept: application/json"
]);

$response = curl_exec($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "<h3>HTTP CODE:</h3>$http";
echo "<h3>Resposta:</h3><pre>$response</pre>";

$data = json_decode($response, true);

echo "<h3>VAR DUMP:</h3><pre>";
var_dump($data);
echo "</pre>";
