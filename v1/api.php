<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/5/17
 * Time: 23:39
 */

require_once 'config.php';
require_once 'vendor/autoload.php';
use Restaurant\Http\Methods as Methods;

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r)  use ($baseURI) {

    /** TOKENS CLOSURES */
    $handlePostToken = function ($args) {
        $tokenController = new \Restaurant\Controllers\TokenController();

        if (!empty($_POST['email'])) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
            $password = $_POST['password'] ?? "";
        } else {
            //Attempt to parse json input
            $json = (object) json_decode(file_get_contents('php://input'));
            if (count((array)$json) >= 2) {
                $email = filter_var($json->email, FILTER_SANITIZE_STRING);
                $password = $json->password;
            } else {
                http_response_code(\Restaurant\Http\StatusCodes::BAD_REQUEST);
                exit();
            }
        }
        return $tokenController->buildToken($email, $password);
    };

    /** TOKEN ROUTE */
    $r->addRoute(Methods::POST, $baseURI . '/tokens', $handlePostToken);
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$pos = strpos($uri, '?');
if ($pos !== false) {
    $uri = substr($uri, 0, $pos);
}

$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($method, $uri);

switch($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(Restaurant\Http\StatusCodes::NOT_FOUND);
        //Handle 404
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(Restaurant\Http\StatusCodes::METHOD_NOT_ALLOWED);
        //Handle 403
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler  = $routeInfo[1];
        $vars = $routeInfo[2];

        $response = $handler($vars);
        echo json_encode($response);
        break;
}
