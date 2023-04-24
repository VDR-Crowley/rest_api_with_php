<?php
    $url = 'https://localhost/restApi/public_html/api';
    $class = '/user';
    $params = '/1';

    $base = curl_init($url.$class.$params);
    curl_setopt($base, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($base, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($base, CURLOPT_SSL_VERIFYHOST, 0);
    $return = curl_exec($base);
    curl_close($base);
    $arrResp = json_decode($return, true);
    echo 'CURL';
    var_dump($arrResp);

    $arrContextOptions=array(
      "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
      ),
    );
    $response = file_get_contents(
        $url.$class.$params,
        false,
        stream_context_create($arrContextOptions)
    );

    $response = json_decode($response, 1);
    echo 'FILE GET';
    var_dump($response);
?>

<script>
    fetch('https://localhost/restApi/public_html/api/user/1', {
        method: 'PUT',
        body: new URLSearchParams({
            name: 'Teste',
            email: 'teste@gmail.com'
        }).toString(),
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    })
</script>


