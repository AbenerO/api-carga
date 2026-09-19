<?php
header('Content-Type: application/json');

$op = $_GET['op'] ?? 'hash';
$inicio = microtime(true);

if ($op === 'hash') {
    // CPU: SHA256 repetido 100,000 veces
    $n = min((int)($_GET['n'] ?? 100000), 1000000);
    $h = 'costosa';
    for ($i = 0; $i < $n; $i++) {
        $h = hash('sha256', $h);
    }
    $resultado = ['operacion' => 'sha256', 'iteraciones' => $n, 'hash' => $h];

} elseif ($op === 'factorial') {
    // CPU: factorial grande (usa bcmul, requiere extensión bcmath)
    $n = min((int)($_GET['n'] ?? 3000), 10000);
    $f = '1';
    for ($i = 2; $i <= $n; $i++) {
        $f = bcmul($f, (string)$i);
    }
    $resultado = ['operacion' => 'factorial', 'n' => $n, 'digitos' => strlen($f)];

} elseif ($op === 'memoria') {
    // Memoria: 100,000 objetos, se recorren y suman
    $n = min((int)($_GET['n'] ?? 100000), 1000000);
    $arr = [];
    for ($i = 0; $i < $n; $i++) {
        $arr[] = ['id' => $i, 'valor' => mt_rand(0, 100), 'txt' => str_repeat('x', 50)];
    }
    $suma = array_sum(array_column($arr, 'valor'));
    $resultado = ['operacion' => 'memoria', 'objetos' => $n, 'suma' => $suma];

} else {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'op invalida']);
    exit;
}

echo json_encode(['ok' => true] + $resultado + ['ms' => round((microtime(true) - $inicio) * 1000)]);