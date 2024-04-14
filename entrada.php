<?php
include_once ('banco.php');
if (verificaLogin()) {
  ?>
<div class='container col-9'>
    <h1 class='h1'>Entrada/Saída de Itens</h1>
    <form method='post' action='salvar.php'>
        <input type='hidden' name='acao' value='entrada'>
        <div class="mb-3">
            <label class="form-label" required>Item*:</label>
            <select class="form-select" name='item'>
               <?php selecionaItens() ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Quantidade de entrada:</label>
            <input type="text" class="form-control" name='entrada'>
        </div>
        <div class="mb-3">
            <label class="form-label">Quantidade de saída:</label>
            <input type="text" class="form-control" name='saida'>
        </div>
        <button type="submit" class="btn btn-primary">Movimentar</button>
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