<?php
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    include_once '../../config/database.php';
    include_once '../../models/Pedido.php';

    $database = new Database();
    $db = $database->getConnection();

    if (!$db) {
        throw new Exception('Erro de conexão com banco de dados');
    }

    $pedido = new Pedido($db);

    $data = json_decode(file_get_contents("php://input"));

    if(!empty($data->id)) {
        $pedido->codigo = $data->id;

        if($pedido->delete()) {
            http_response_code(200);
            echo json_encode(array(
                "sucesso" => true,
                "mensagem" => "Pedido excluído com sucesso!"
            ));
        } else {
            http_response_code(500);
            echo json_encode(array(
                "sucesso" => false,
                "mensagem" => "Erro ao excluir pedido"
            ));
        }
    } else {
        http_response_code(400);
        echo json_encode(array(
            "sucesso" => false,
            "mensagem" => "ID do pedido é obrigatório"
        ));
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro interno: ' . $e->getMessage()
    ]);
}
?>