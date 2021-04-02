<?php 
require_once("../../conexao.php");

$id = $_POST['id'];

//BUSCAR IMAGEM PARA EXLUSÃO NA PASTA
$query_con = $pdo->query("SELECT * FROM categorias WHERE id = '$id'");
$res_con = $query_con->fetchAll(pdo::FETCH_ASSOC);
$imagem = $res_con[0]['foto'];
unlink('../../img/categorias/' .$imagem);

$query_con = $pdo->query("DELETE from categorias WHERE id = '$id'");

echo 'Excluído com Sucesso!';

 ?>