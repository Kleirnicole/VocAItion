<?php
function call_prediction_api(array $answers, array $riasec): array {
    $payload = json_encode([
        'answers' => $answers,
        'riasec' => $riasec
    ]);

    $ch = curl_init(PREDICT_API_URL);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json'
        ],
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_TIMEOUT => 15
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($error || $status !== 200) {
        return ['success' => false, 'error' => $error ?: "HTTP $status"];
    }

    $data = json_decode($response, true);
    return ['success' => true, 'data' => $data];
}