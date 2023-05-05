<?php
test('post', function () {
    $url = 'https://localhost/restApi/public_html/api';
    $class = '/user';
    $post = [
      'name' => 'Vando Testando Lindamente 4',
      'email' => 'dassads4@gmail.com',
      'password' => '$Vando1234',
    ];

    $ch = curl_init($url.$class);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $response = json_decode(curl_exec($ch), true);
    $id = strval($response['data']['id']);

    expect($id)->toBeString();

    curl_setopt($ch, CURLOPT_URL, $url.$class."/".$id);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    $result = json_decode(curl_exec($ch));
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    expect($httpCode)->toBe(200);

});
