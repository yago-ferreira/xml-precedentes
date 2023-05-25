<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!empty($_FILES['arquivos'])) {
    enviarArquivosPrecedentes($_FILES['arquivos']);
    // Redireciona para a mesma página
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  } else {
    echo "Não encontrou o arquivo";
  }
}



function enviarArquivosPrecedentes($arquivos)
{
  $numFiles = count($arquivos['name']);

  for ($i = 0; $i < $numFiles; $i++) {
    $nomeArquivo = strtolower($arquivos['name'][$i]);
    if (!existeArquivo($nomeArquivo)) {
      criarArquivo($nomeArquivo);
      enviarArquivo($nomeArquivo);
    }
  }
}

function existeArquivo($nomeArquivo)
{
  if (file_exists($nomeArquivo)) {
    echo "<li>Arquivo:$nomeArquivo já existe na base!</li>";
    return true;
  } else {

    return false;
  }
}

function criarArquivo($nomeArquivo)
{

  $conteudo = "<xml>$nomeArquivo</xml>"; // Conteúdo do arquivo XML a ser criado
  file_put_contents($nomeArquivo, $conteudo); // Cria o arquivo com o conteúdo fornecido
  // Remove tudo depois do caractere '.'

  $nomeArquivoSemExtensao = strstr($nomeArquivo, '.', true);

  if (!isset($_COOKIE[$nomeArquivoSemExtensao])) {
    setcookie($nomeArquivoSemExtensao, "0", 0, "/");
  };

  echo '<li>Arquivo(s) criado(s) com sucesso!</li>';
}

function enviarArquivo($nomeArquivo)
{
  echo "<li>Arquivo:$nomeArquivo enviado com sucesso!</li>";
}
?>


<!doctype html>
<html lang="pt">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FAC Sistemas e Consultoria</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
  <!-- Image and text -->
<nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="#">
    <img src="https://www.facsistemas.com.br/images/logo-footer.png" width="80" height="80" class="d-inline-block align-top" alt="">
  </a>
</nav>
  <div class="container" style="margin-top: 50px;">
    <h1>Envio de Arquivos XML Precedentes</h1>
    <!-- Adicione este código dentro do contêiner -->
    <form action="" method="post" onsubmit="return validarArquivos()" enctype="multipart/form-data">
      <div class="form-group">
        <label>Clique no botão abaixo para enviar os arquivos XML precedentes:</label>
        <ul>
          <li>Produtos</li>
          <li>Clientes</li>
          <li>Fornecedores</li>
        </ul>
        <input type="file" name="arquivos[]" required accept=".xml" multiple>
      </div>





      <div class="form-group mt-2">
        <button type="submit" class="btn btn-primary">Enviar Arquivos</button>
      </div>
    </form>

    <div class="mt-5">
      <label>Arquivos já incluso:</label>
      <ul>
        <?= isset($_COOKIE["produtos"]) ? "<li>Produtos</li>" : "" ?>
        <?= isset($_COOKIE["clientes"]) ? "<li>Clientes</li>" : "" ?>
        <?= isset($_COOKIE["fornecedores"]) ? "<li>Fornecedores</li>" : "" ?>
      </ul>
    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <script>
    function validarArquivos() {
      var files = document.getElementsByName("arquivos[]")[0].files;

      for (var i = 0; i < files.length; i++) {
        var fileName = files[i].name.toLowerCase();
        console.log(fileName);

        if (fileName !== "produtos.xml" && fileName !== "clientes.xml" && fileName !== "fornecedores.xml") {
          alert("Por favor, selecione envie arquivos XML precedentes como'Produtos', 'Clientes' e 'Fornecedores'.");
          return false;
        }
      }

      return true;
    }
  </script>

</body>

</html>