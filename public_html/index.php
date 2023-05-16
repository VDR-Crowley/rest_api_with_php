<?php
    header('Content-Type: application/json');
    require_once '../vendor/autoload.php';

    function api($url): void
    {
        array_shift($url);
        $service = "App\Services\\".ucfirst($url[0])."Service";
        array_shift($url);
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        try {
            $response = call_user_func_array([new $service, $method], $url);
            http_response_code(200);
            echo json_encode(['status' => 'success', 'data' => $response]);
            exit;
        } catch (\Exception $error) {
            http_response_code(404);
            echo json_encode(
              array('status' => 'error', 'data' => $error->getMessage()),
              JSON_UNESCAPED_UNICODE
            );
            exit;
        }
    }

    if ($_GET['url']) {
        $url = explode('/', $_GET['url']);
        match($url[0]) {
            'api' => api($url),
        };
    }
