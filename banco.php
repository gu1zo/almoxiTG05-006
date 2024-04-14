<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('BASE', 'almoxitg');

$conn = new MySQLi(HOST, USER, PASS, BASE);
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

function logar()
{
    if (isset($_POST['login']) && (isset($_POST['senha']))) {

        $login = $GLOBALS['conn']->real_escape_string($_POST['login']);
        $senha = $GLOBALS['conn']->real_escape_string($_POST['senha']);

        $sql = "SELECT * from usuarios WHERE login='$login' AND senha='$senha'";
        $res = $GLOBALS['conn']->query($sql) or die('Falha na execução do código SQL: ' . $GLOBALS['conn']->error);
        $qtd = $res->num_rows;

        if ($qtd == 1) {
            $dados = $res->fetch_assoc();
            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $dados['id'];
            $_SESSION['login'] = $dados['login'];
            $_SESSION['senha'] = $dados['senha'];

            ?>
            <script>
                alert('Usuario logado com sucesso');
                location.href = 'index.php';
            </script>
            <?php
        } else {
            ?>
            <script>
                alert('Usuario e senha não encontrados. Tente novamente!');
                location.href = 'indexNovo.php?page=login';
            </script>
            <?php
        }
    }
}

function verificaLogin()
{
    if (!isset($_SESSION)) {
        session_start();
    }

    if (!isset($_SESSION['id'])) {
        return false;
    } else {
        return true;
    }
}

function cadastrarItem()
{
    if (isset($_POST['item'])) {
        $item_id = $GLOBALS['conn']->real_escape_string($_POST['item']);
        $tipo = $GLOBALS['conn']->real_escape_string($_POST['tipo']);

        $qtd_cautelado = ($_POST['qtd_cautelada'] > 0) ? $_POST['qtd_cautelada'] : 0;

        $qtd_estoque = ($_POST['qtd_estocada'] > 0) ? $_POST['qtd_estocada'] : 0;
        $total = $qtd_cautelado + $qtd_estoque;

        $sql = "INSERT INTO itens (item_id, tipo, qtd_cautelado, qtd_estoque, total) VALUES ('$item_id', '$tipo', '$qtd_cautelado', '$qtd_estoque', '$total')";
        $res = $GLOBALS['conn']->query($sql) or die('Falha na execução do código SQL: ' . $GLOBALS['conn']->error);


        if ($res) {
            ?>
            <script>
                alert('Item cadastrado com sucesso!')
                location.href = 'index.php?page=principal';
            </script>
            <?php
        }
    }
}
function selecionaItens()
{
    $sql = "SELECT id, item_id, tipo FROM itens";
    $res = $GLOBALS['conn']->query($sql) or die('Falha na execução do código SQL: ' . $GLOBALS['conn']->error);
    $qtd = $res->num_rows;

    if ($qtd > 0) {
        while ($row = $res->fetch_object()) {
            ?>
            <option value="<?php echo $row->id ?>"><?php echo $row->item_id; ?> - <?php echo $row->tipo ?></option>
            <?php
        }
    }
}
function entrada()
{
    if (isset($_POST['item'])) {
        $item = $GLOBALS['conn']->real_escape_string($_POST['item']);

        $entrada = ($_POST['entrada'] > 0) ? $_POST['entrada'] : 0; // entrada estoque
        $saida = ($_POST['saida'] > 0) ? $_POST['saida'] : 0; // saída estoque

        $saldo = $entrada - $saida;

        $sql = "SELECT qtd_cautelado, qtd_estoque, total FROM itens WHERE id='$item'";
        $res = $GLOBALS['conn']->query($sql) or die('Falha na execução do código SQL: ' . $GLOBALS['conn']->error);
        $qtd = $res->num_rows;

        if ($qtd > 0) {
            while ($row = $res->fetch_object()) {

                $estoqueBanco = $row->qtd_estoque;
                $totalBanco = $row->total;

                $estoqueFinal = $estoqueBanco + $saldo;

                if ($estoqueFinal >= 0) {
                    $totalFinal = $totalBanco + $saldo;

                    $sql = "UPDATE itens SET qtd_estoque ='$estoqueFinal', total ='$totalFinal' WHERE id='$item'";
                    $res = $GLOBALS['conn']->query($sql) or die('Falha na execução do código SQL: ' . $GLOBALS['conn']->error);

                    if ($res) {
                        ?>
                        <script>
                            alert('Itens movimentados!');
                            location.href = "index.php?page=entrada";
                        </script>
                        <?php
                    }
                } else {
                    ?>
                    <script>
                        alert('Não há o suficiente em estoque para essa movimentação!');
                        location.href = "index.php?page=entrada";
                    </script>
                    <?php
                }

            }
        }
    }
}

function cautelada()
{
    if (isset($_POST['item'])) {
        $item = $GLOBALS['conn']->real_escape_string($_POST['item']);

        $devolvido = ($_POST['devolvido'] > 0) ? $_POST['devolvido'] : 0;
        $cautelado = ($_POST['cautelado'] > 0) ? $_POST['cautelado'] : 0;

        $saldo = $devolvido - $cautelado;

        $sql = "SELECT qtd_cautelado, qtd_estoque FROM itens WHERE id='$item'";
        $res = $GLOBALS['conn']->query($sql) or die('Falha na execução do código SQL: ' . $GLOBALS['conn']->error);
        $qtd = $res->num_rows;

        if ($qtd > 0) {
            while ($row = $res->fetch_object()) {

                $estoqueBanco = $row->qtd_estoque;
                $cauteladoBanco = $row->qtd_cautelado;

                $estoqueFinal = $estoqueBanco + $saldo;
                if (($estoqueFinal >= 0)) {
                    $cauteladoFinal = $cauteladoBanco - $saldo;
                    if ($cauteladoFinal >= 0) {
                        $sql = "UPDATE itens SET qtd_estoque ='$estoqueFinal', qtd_cautelado ='$cauteladoFinal' WHERE id='$item'";
                        $res = $GLOBALS['conn']->query($sql) or die('Falha na execução do código SQL: ' . $GLOBALS['conn']->error);

                    } else {
                        ?>
                        <script>
                            alert('Não há o suficiente cautelado para essa movimentação!');
                            location.href = "index.php?page=cautelar";
                        </script>
                        <?php
                    }


                    if ($res) {
                        ?>
                        <script>
                            alert('Itens movimentados!');
                            location.href = "index.php?page=principal";
                        </script>
                        <?php
                    }
                } else {
                    ?>
                    <script>
                        alert('Não há o suficiente em estoque para essa movimentação!');
                        location.href = "index.php?page=cautelar";
                    </script>
                    <?php
                }
            }
        }
    }
}

function tabelaPrincipal()
{
    $sql = "SELECT * from itens";
    $res = $GLOBALS['conn']->query($sql) or die('Falha na execução do código SQL: ' . $GLOBALS['conn']->error);
    $qtd = $res->num_rows;

    if ($qtd > 0) {
        while ($row = $res->fetch_object()) {
            ?>
            <th scope="row"><?php echo $row->id ?></th>
            <td><?php echo $row->item_id ?></td>
            <td><?php echo $row->tipo ?></td>
            <td><?php echo $row->qtd_cautelado ?></td>
            <td><?php echo $row->qtd_estoque ?></td>
            <td><?php echo $row->total ?></td>
            </tr>
            <?php
        }
    }
}
?>