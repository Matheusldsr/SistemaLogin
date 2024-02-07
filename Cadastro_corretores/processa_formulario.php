<?php
 $serverName = "localhost";
 $username = "root";
 $password = "";
 $db_name = "sistemalogin";

$connect = new mysqli($serverName, $username, $password, $db_name); // Conexão

if ($connect->connect_error) {
    die("Falha na conexão: " . $connect->connect_error);
}

$erro = "";
  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 if (isset($_POST['btnEnviar'])) {
    // Verificar se os campos estão sendo enviados corretamente
  $nome = $_POST['inpnome'];
  $cpf = $_POST['inpcpf'];
  $creci = $_POST['inpcreci'];

        // Verificar se o CPF já existe no banco de dados
        $sql_check_cpf = "SELECT COUNT(*) AS total FROM corretores WHERE cpf = ?";
        $stmt_check_cpf = $connect->prepare($sql_check_cpf);
        $stmt_check_cpf->bind_param("s", $cpf);
        $stmt_check_cpf->execute();
        $result_check_cpf = $stmt_check_cpf->get_result();
        $row_check_cpf = $result_check_cpf->fetch_assoc();
        $stmt_check_cpf->close();

        if ($row_check_cpf['total'] > 0) {
            // CPF já existe, exibir mensagem e impedir cadastro
            echo "<script>alert('CPF já cadastrado no sistema!');</script>";
        } elseif ($nome === "André Nunes") {
            echo "<script>alert('Usuário está na blacklist!');</script>";
        }
        else
        {
            // CPF não existe, inserir novo registro no banco de dados
            $sql_insert = "INSERT INTO corretores (nome, cpf, creci) VALUES (?, ?, ?)";
            $stmt_insert = $connect->prepare($sql_insert);

            if ($stmt_insert) {
                $stmt_insert->bind_param("sss", $nome, $cpf, $creci);
                $result_insert = $stmt_insert->execute();

                if ($result_insert) {
                    echo "<script>alert('Registro inserido com sucesso!');</script>";
                    echo "<script>window.location.href = 'index.php';</script>"; // Redirecionar para index.php
                } else {
                    $erro = "Erro ao cadastrar os dados: " . $stmt_insert->error;
                }

                // Fechar a instrução preparada de inserção
                $stmt_insert->close();
            } else {
                $erro = "Erro na preparação da instrução de inserção: " . $connect->error;
            }
        }
    } elseif (isset($_POST['btnSalvar'])) {
        // Verificar se os campos estão sendo enviados corretamente
        $id = $_POST['id_editar'];
        $nome = $_POST['inpnome'];
        $cpf = $_POST['inpcpf'];
        $creci = $_POST['inpcreci'];

        // Lógica para atualizar um registro no banco de dados
        $sql_update = "UPDATE corretores SET nome=?, cpf=?, creci=? WHERE id=?";
        $stmt_update = $connect->prepare($sql_update);

        if ($stmt_update) {
            $stmt_update->bind_param("sssi", $nome, $cpf, $creci, $id);
            $result_update = $stmt_update->execute();

            if ($result_update) {
                echo "<script>alert('Registro atualizado com sucesso!');</script>";
                echo "<script>window.location.href = 'index.php';</script>"; // Redirecionar para index.php
            } else {
                $erro = "Erro ao atualizar os dados: " . $stmt_update->error;
            }

            // Fechar a instrução preparada de atualização
            $stmt_update->close();
        } else {
            $erro = "Erro na preparação da instrução de atualização: " . $connect->error;
        }
    }
}

$connect->close();

?>
