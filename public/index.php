<?php

// Configura la cabecera para respuestas JSON
header('Content-Type: application/json');

// Incluye archivos de configuración y clases
require_once '../vendor/autoload.php';
require_once '../config/config.php';
require_once '../config/routes.php';
require_once '../config/container.php';
require_once '../Http/HttpException.php'; // Incluye la clase HttpException

use Exceptions\HttpException; // Usa la clase HttpException

// Configura el contenedor de servicios
$container = require '../config/container.php';

// Configura el enrutamiento
$requestUri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Carga las rutas
$routes = require '../config/routes.php';

// Verifica si la ruta solicitada y el método están disponibles
if (isset($routes[$method])) {
    foreach ($routes[$method] as $routePattern => $controllerAction) {
        if (preg_match('#^' . str_replace(['{id}'], ['(\d+)'], $routePattern) . '$#', $requestUri, $matches)) {
            array_shift($matches); // Elimina el primer elemento que es la URI completa

            list($controllerClass, $action) = $controllerAction;

            if (isset($container[$controllerClass])) {
                $controller = $container[$controllerClass];
                $requestData = json_decode(file_get_contents('php://input'), true);

                try {
                    if (method_exists($controller, $action)) {
                        $arguments = [];

                        if (in_array($action, ['createUser', 'updateUser']) && is_array($requestData)) {
                            $arguments[] = $requestData;
                        }

                        if (strpos($routePattern, '{id}') !== false) {
                            $arguments[] = (int)$matches[0];
                        }

                        $response = call_user_func_array([$controller, $action], $arguments);
                        echo json_encode($response);
                    } else {
                        throw new HttpException('Action not found', 500);
                    }
                } catch (HttpException $e) {
                    http_response_code($e->getStatusCode());
                    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                } catch (\Exception $e) {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred: ' . $e->getMessage()]);
                }

            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Controller not found']);
            }
            exit;
        }
    }
}

http_response_code(404);
echo json_encode(['status' => 'error', 'message' => 'Route not found']);
