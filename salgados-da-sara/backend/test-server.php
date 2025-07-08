<?php
// Servidor de teste simples
echo "Servidor PHP funcionando!\n";
echo "Data/Hora: " . date('Y-m-d H:i:s') . "\n";
echo "Porta: 8000\n";

// Testar conexão com banco
try {
    include_once 'config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    
    if ($db) {
        echo "Conexão com PostgreSQL: OK\n";
    } else {
        echo "Conexão com PostgreSQL: ERRO\n";
    }
} catch (Exception $e) {
    echo "Erro ao conectar com banco: " . $e->getMessage() . "\n";
}
?>