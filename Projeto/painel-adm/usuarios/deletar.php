<?php 
    require_once("../../conexao.php");
     
    $id = $_POST['id'];
    $query_con = $pdo->query("DELETE from tbl_usuario WHERE id = '$id'");
    echo 'Deletado com Sucesso!';
?>