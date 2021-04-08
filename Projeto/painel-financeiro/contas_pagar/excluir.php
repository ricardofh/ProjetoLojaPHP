<?php 
require_once("../../conexao.php");

$id = $_POST['id'];

//BUSCAR IMAGEM PARA EXLUSÃO NA PASTA
$query_con = $pdo->query("SELECT * FROM contas_pagar WHERE id = '$id'");
$res_con = $query_con->fetchAll(pdo::FETCH_ASSOC);

$total_reg = @count($res_con);
if($total_reg > 0){
	$pago = $res_con[0]['pago'];
    $descricao = $res_con[0]['descricao'];
	if($pago == 'Sim'){
		echo 'Essa conta já está paga, não é permitida sua deleção';
		exit();
	}
    if($descricao == 'Compra de produtos'){
		echo 'Não é permitida a exclusão dessa conta';
		exit();
	}
}

//EXCLUIR IMAGEM DA PASTA
$imagem = $res_con[0]['arquivo'];

if($imagem != 'sem-foto.jpg'){
    unlink('../../img/contas_pagar/' .$imagem);
}

$query_con = $pdo->query("DELETE from contas_pagar WHERE id = '$id'");

echo 'Excluído com Sucesso!';

 ?>