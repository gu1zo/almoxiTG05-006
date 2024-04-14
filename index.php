<?php
include_once ('banco.php');
if (verificaLogin()) {
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
  <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="outros/js.js"></script>
    <title>Site Pi</title>
  </head>

  <body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Almoxi TG</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" href="?page=principal">Tabela Principal</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?page=cadastrarItens">Cadastrar Itens</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?page=entrada">Entrada/saída</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?page=cautelar">Cautelar/Devolver</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?page=login">Logar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Deslogar</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class='container'>
      <div class="row">
        <div class="col mt-5">
          <?php
          switch (@$_REQUEST["page"]) {

            case 'principal':
              include ('principal.php');
              break;
            case 'login':
              include ('login.php');
              break;
            case 'logout':
              include ('logout.php');
              break;
            case 'cadastrarItens':
              include ('cadastrarItens.php');
              break;
            case 'entrada':
              include ('entrada.php');
              break;
              case 'cautelar':
                include ('cautelar.php');
                break;
            default:
              include ('principal.php');
              break;
          }
          ?>
        </div>
      </div>
    </div>
  </body>

  </html>
  <?php
} else {
  ?>
  <script>
    alert('É necessário logar para utilizar o sistema!');
    location.href='indexNovo.php';
  </script>
  <?php
}
?>