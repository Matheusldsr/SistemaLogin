<?php require_once 'processa_formulario.php';?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Formulário Login</title>
 <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class= "page-container">
<h1 id="titulo">Cadastro de Corretores</h1>
  <div class="formulario-container">
        <!--Formulário-->
   <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
     <input type="text" name="inpcpf" id="inpcpf" maxlength="11" placeholder="Digite seu CPF (somente números)" pattern="[0-9]{11}" title="CPF deve ter exatamente 11 dígitos numéricos" required>
     <input type="text" name="inpcreci" id="inpcreci" maxlength="8" placeholder="Digite o seu Creci" pattern="\d+" title="Creci deve ter apenas números" required><br>
     <input type="text" name="inpnome" id="inpnome" maxlength="20" placeholder="Digite seu nome" minlength="2" required><br>
     <input type="hidden" name="id_editar" id="id_editar"> <!-- Campo Oculto -->
     <button type="submit" name="btnEnviar" id="btnEnviar">Enviar</button>
    </form>
   </div>
   </div>
  <?php
    // Exibir a tabela de corretores
   $connect = new mysqli("localhost", "root", "", "sistemalogin");

    // Verificar a conexão
   if ($connect->connect_error) {
        die("Falha na conexão: " . $connect->connect_error);
    }

    // Consultar os corretores
   $sql = "SELECT * FROM corretores";
   $result = $connect->query($sql);
  ?>

    <!-- Exibir a tabela -->
  <div class="container">
   <table border="1">
    <tr>
     <th>ID</th>
     <th>Nome</th>
     <th>CPF</th>
     <th>CRECI</th>
     <th>Ações</th>
     </tr>
    <?php while ($row = $result->fetch_assoc()) : ?>
    <tr>
     <td><?php echo $row['id']; ?></td>
     <td><?php echo $row['nome']; ?></td>
     <td><?php echo $row['cpf']; ?></td>
     <td><?php echo $row['creci']; ?></td>
     <td>
      <button type="button" onclick="editar(<?php echo $row['id']; ?>, '<?php echo $row['nome']; ?>', '<?php echo $row['cpf']; ?>', '<?php echo $row['creci']; ?>')">Editar</button>
      <button type="button" onclick="excluir(<?php echo $row['id']; ?>)">Excluir</button>
     </td>
    </tr>
<?php endwhile; ?>
     </table>
    </div>
 <script>
  function editar(id, nome, cpf, creci) {
   document.getElementById('inpnome').value = nome;
   document.getElementById('inpcpf').value = cpf;
   document.getElementById('inpcreci').value = creci;
   document.getElementById('id_editar').value = id;
   document.getElementById('btnEnviar').innerText = 'Salvar';
   document.getElementById('btnEnviar').setAttribute('name', 'btnSalvar');
   document.getElementById('titulo').innerText = 'Editor de Corretores';
}

   function salvarEdicao() {
        document.getElementById('btnSalvar').type = 'submit';
    }

    function excluir(id) {
        if (confirm("Tem certeza que deseja excluir este registro?")) {
            window.location.href = 'excluir_registro.php?id=' + id;
        }
    }

    function atualizarTabela() {
        // Recarregar a página após um pequeno intervalo para dar tempo ao PHP de processar a ação
        setTimeout(function() {
            window.location.reload();
        }, 500);
    }
    </script>
</body>
</html>
