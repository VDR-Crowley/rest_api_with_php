<?php
    $url = 'http://localhost/restApi/public_html/api';
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

    echo "------------------------------------------------------------------------------------------------------------<br/>";
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

    echo "--------------------------------------------------------------------------<br/>";
    echo "POST";

    $post = [
      'name' => 'Vando Testando Lindamente 2',
      'email' => 'dassads2@gmail.com',
      'password' => '$Vando1234',
    ];

    $ch = curl_init($url.$class);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
    // execute!
    $return = curl_exec($ch);
    $response = json_decode($return, true);
    var_dump($return);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);
    var_dump($httpCode);

    echo "-----------------------------------------------------------------------<br/>";
    echo "DELETE";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url.$class.'/15');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
//    curl_setopt($ch, CURLOPT_POSTFIELDS, '16');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // On dev server only!
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/x-www-form-urlencoded', // if the content type is json
      )
    );
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $result = json_decode($result);

    curl_close($ch);

    var_dump($result);
    var_dump($httpCode);
?>

<script>
    // fetch('https://localhost/restApi/public_html/api/user/1', {
    //     method: 'PUT',
    //     body: new URLSearchParams({
    //         name: 'Teste',
    //         email: 'teste@gmail.com'
    //     }).toString(),
    //     headers: {
    //         'Content-Type': 'application/x-www-form-urlencoded',
    //     }
    // })
</script>


