<?php
include_once ('banco.php');
if (verificaLogin()) {
  ?>
<div class='container col-9'>
    <h1 class='h1'>Cadastrar Novo Item</h1>
  <form method='post' action='salvar.php'>
    <input type='hidden' name='acao' value='cadastrarItem'>
    <div class="mb-3">
      <label class="form-label" required>Item*:</label>
      <input type="text" class="form-control" name='item'>
    </div>
    <div class="mb-3">
      <label class="form-label" required>Tamanho/Tipo*:</label>
      <input type="text" class="form-control" name='tipo'>
    </div>
    <div class="mb-3">
      <label class="form-label">Quantidade Cautelada:</label>
      <input type="text" class="form-control" name='qtd_cautelada'>
    </div>
    <div class="mb-3">
      <label class="form-label">Quantidade Estocada:</label>
      <input type="text" class="form-control" name='qtd_estocada'>
    </div>
    <button type="submit" class="btn btn-primary">Cadastrar</button>
  </form>
</div>
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