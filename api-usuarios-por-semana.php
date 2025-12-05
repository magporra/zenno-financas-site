<?php
header("Content-Type: application/json");

// CONFIGURAÇÕES DO SUPABASE
$supabaseUrl = 'https://kdsuvlaeepwjzqnfvxxr.supabase.co';
$supabaseKey =  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtkc3V2bGFlZXB3anpxbmZ2eHhyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxNTMwMTIsImV4cCI6MjA3MTcyOTAxMn0.iuOiaoqm3BhPyEMs6mtn2KlA2CIuYdnkcfmc36_Z8t8';

// BUSCA APENAS A COLUNA DE DATA
$url = $supabaseUrl . "/rest/v1/usuarios?select=criado_em";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $supabaseKey",
    "Authorization: Bearer $supabaseKey"
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

// AGRUPAR POR SEMANA
$semanas = [];

foreach ($data as $usuario) {
    $dataCriacao = date("Y-m-d", strtotime($usuario["criado_em"]));

    // FORMATO EX: 2025-03 (ano-semana)
    $anoSemana = date("Y-W", strtotime($dataCriacao));

    if (!isset($semanas[$anoSemana])) {
        $semanas[$anoSemana] = 0;
    }

    $semanas[$anoSemana]++;
}

// RETORNAR PARA O JS
echo json_encode([
    "labels" => array_keys($semanas),
    "values" => array_values($semanas)
]);
