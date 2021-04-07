<?php 
require_once("../../conexao.php");

$id = $_POST['id'];

//BUSCAR IMAGEM PARA EXLUSÃO NA PASTA
$query_con = $pdo->query("SELECT * FROM categorias WHERE id = '$id'");
$res_con = $query_con->fetchAll(pdo::FETCH_ASSOC);

//VERIFICAR SE EXISTE REGISTRO RELACIONADO
$query_p = $pdo->query("SELECT * FROM produtos WHERE categoria = '$id'");
$res_p = $query_p->fetchAll(pdo::FETCH_ASSOC);
if(@count($res_p) > 0){
    echo 'Existem produtos cadastrados com essa categoria, exclua o mesmo para depois excluir a categoria';
    exit();
}

//EXCLUIR IMAGEM DA PASTA
$imagem = $res_con[0]['foto'];

if($imagem != 'sem-foto.jpg'){
    unlink('../../img/categorias/' .$imagem);
}

$query_con = $pdo->query("DELETE from categorias WHERE id = '$id'");

echo 'Excluído com Sucesso!';

 ?>