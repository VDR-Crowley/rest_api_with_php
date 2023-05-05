<?php
$url = 'https://localhost/restApi/public_html/api';
$class = '/user';
$params = '/1';

test('get', function () use ($url, $class, $params) {
    $mockUser = new \MocksTest\UserTest();

    $base = curl_init($url.$class.$params);
    curl_setopt($base, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($base, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($base, CURLOPT_SSL_VERIFYHOST, 0);
    $return = curl_exec($base);
    curl_close($base);
    $arrResp = json_decode($return, true);

    expect($mockUser->name)->toBe($arrResp['data']['name']);
    expect($mockUser->email)->toBe($arrResp['data']['email']);
    expect(!!$arrResp['data']['id'])->toBe(true);
    expect(!!$arrResp['data']['password'])->toBe(true);
});
