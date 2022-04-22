<?php
// Permisos para acceder a la API desde cualquier cliente.
// Permissions to access the API from any client.
// Allow from any origin.
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
}
// Access-Control headers are received during OPTIONS requests.
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    exit(0);
}
header('Content-Type: application/json; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');
// Incluimos nuestra clase Cliente.
// We include our Client class.
require_once('./models/cliente.class.php');
// Realizamos operaciones a la base de datos.
// We perform operations on the database.
if (isset($_GET['url'])) {
    $url = $_GET['url'];
    $number = intval(preg_replace('/[^0-9]+/', '', $url), 10);
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            switch ($url) {
                case 'clientes':
                    print_r(json_encode(Cliente::getAllClients()));
                    break;
                case "clientes/$number":
                    print_r(json_encode(Cliente::getClientWhere($number)));
                    break;
                default:

                    break;
            }
            http_response_code(200);
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'));
            switch ($url) {
                case 'clientes':
                    if ($data != null) {
                        if (Cliente::addClient($data->cliente_nombre, $data->cliente_apepat, $data->cliente_apemat, $data->cliente_fnacimiento, $data->cliente_genero)) {
                            $response = [
                                'message' => '!Cliente agregado correctamente¡',
                                'error' => false
                            ];
                            print_r(json_encode($response));
                            http_response_code(200);
                        } else {
                            $response = [
                                'message' => '!No se pudo agregar el cliente¡',
                                'error' => true
                            ];
                            print_r(json_encode($response));
                            http_response_code(400);
                        }
                    } else {
                        $response = [
                            'message' => '!Método incorrecto¡',
                            'error' => true
                        ];
                        print_r(json_encode($response));
                        http_response_code(405);
                    }
                    break;
                default:

                    break;
            }
            break;
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'));
            switch ($url) {
                case "clientes/$number":
                    if ($data != null) {
                        if (Cliente::updateClient($data->cliente_nombre, $data->cliente_apepat, $data->cliente_apemat, $data->cliente_fnacimiento, $data->cliente_genero, $number)) {
                            $response = [
                                'message' => '!Cliente modificado correctamente¡',
                                'error' => false
                            ];
                            print_r(json_encode($response));
                            http_response_code(200);
                        } else {
                            $response = [
                                'message' => '!No se pudo modificar el cliente¡',
                                'error' => true
                            ];
                            print_r(json_encode($response));
                            http_response_code(400);
                        }
                    } else {
                        $response = [
                            'message' => '!Método incorrecto¡',
                            'error' => true
                        ];
                        print_r(json_encode($response));
                        http_response_code(405);
                    }
                    break;
                default:

                    break;
            }
            break;
        case 'DELETE':
            switch ($url) {
                case "clientes/$number":
                    if (Cliente::deleteClient($number)) {
                        $response = [
                            'message' => '!Cliente eliminado correctamente¡',
                            'error' => false
                        ];
                        print_r(json_encode($response));
                        http_response_code(200);
                    } else {
                        $response = [
                            'message' => '!No se pudo eliminar el cliente¡',
                            'error' => true
                        ];
                        print_r(json_encode($response));
                        http_response_code(400);
                    }
                    break;
                default:

                    break;
            }
            break;
        default:
            $response = [
                'message' => '!Método incorrecto¡',
                'error' => true
            ];
            print_r(json_encode($response));
            http_response_code(405);
            break;
    }
} else {
    // Metadatos
    // Metadata
    $response['rutas'] = [
        'clientes' => [
            'GET /clientes',
            'GET /clientes/$id',
            'POST /clientes',
            'PUT /clientes/$id',
            'DELETE /clientes/$id'
        ]
    ];
    print_r(json_encode($response));
}
