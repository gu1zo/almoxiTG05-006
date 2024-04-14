<?php
include_once ('banco.php');
switch ($_REQUEST['acao']) {
    
    case 'logar':
        logar();
        break;
    case 'cadastrarItem':
        cadastrarItem();
        break;
    case 'entrada':
        entrada();
        break;
    case 'cautelada':
        cautelada();
        break;
}
?>