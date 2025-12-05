<?php
// ====================================
// CONFIGURAÇÃO DO SUPABASE
// ====================================
$supabaseUrl = 'https://kdsuvlaeepwjzqnfvxxr.supabase.co';
$supabaseKey =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtkc3V2bGFlZXB3anpxbmZ2eHhyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxNTMwMTIsImV4cCI6MjA3MTcyOTAxMn0.iuOiaoqm3BhPyEMs6mtn2KlA2CIuYdnkcfmc36_Z8t8';
$tabela = 'admins';

// ====================================
// BUSCAR TODOS OS ADMS
// ====================================
$url = $supabaseUrl . "/rest/v1/$tabela?select=*";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $supabaseKey",
    "Authorization: Bearer $supabaseKey",
    "Content-Type: application/json",
    "Prefer: return=representation"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$dados = json_decode($response, true);

// ------------------------------------
// EVITA ERROS CASO O RETORNO NÃO SEJA JSON
// ------------------------------------
if (!is_array($dados)) {
    $dados = [];
}

// Retorno como JSON
header("Content-Type: application/json; charset=UTF-8");
echo json_encode($dados, JSON_PRETTY_PRINT);
exit;
?>
