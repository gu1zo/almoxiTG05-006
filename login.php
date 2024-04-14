<div class='container col-9'>
  <form method='post' action='salvar.php'>
  <h1 class='h1'>Login</h1>
    <input type='hidden' name='acao' value='logar'>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Login</label>
      <input type="text" class="form-control" name='login'>
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Senha</label>
      <input type="password" class="form-control" name='senha'>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
</div>