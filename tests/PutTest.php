<?php
test('put', function () {
    $url = 'https://localhost/restApi/public_html/api';
    $class = '/user';
    $params = '/2';

    $fileData = [
      'name' => 'Vando Testando PUT',
      'email' => 'TestandoPut@gmail.com',
    ];

    $ch = curl_init($url.$class.$params);
    $header = "Content-Type: application/x-www-form-urlencoded";
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array($header));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fileData));
    $response = json_decode(curl_exec($ch), true);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    expect($httpCode)->toBe(200);
    expect($response['data'])->toBe('Usuário(a) foi edito com sucesso!');

});
