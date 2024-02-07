<?php
require_once 'processa_formulario.php';
$connect = mysqli_connect($serverName, $username, $password, $db_name); // Conexão

if ($connect->connect_error) {
    die("Falha na conexão: " . $connect->connect_error);
}

$id = $_GET['id'];

$sql = "DELETE FROM corretores WHERE id = $id";
$result = $connect->query($sql);

if ($result) {
    header("Location: index.php"); // Volta para o index
    exit();
} else {
    echo "Erro ao excluir o registro: " . $connect->error;
}

$connect->close();
?>
