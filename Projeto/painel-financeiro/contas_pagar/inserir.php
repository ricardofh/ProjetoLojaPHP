<?php 
require_once("../../conexao.php");
@session_start();

$id_usuario = $_SESSION['id_usuario'];

$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$id = $_POST['id'];

$query = $pdo->query("SELECT * from contas_pagar WHERE id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$pago = $res[0]['pago'];
	$descricao = $res[0]['descricao'];
	if($pago == 'Sim'){
		echo 'Essa conta já está paga, não é permitida sua edição';
		exit();
	}
	if($descricao == 'Compra de produtos'){
		echo 'Não é permitida a edição dessa conta';
		exit();
	}
}


//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img =  date('d-m-Y H:i:s') . '-' .  @$_FILES['imagem']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../img/contas_pagar/' .$nome_img;
if (@$_FILES['imagem']['name'] == ""){
  $imagem = "sem-foto.jpg";
}else{
    $imagem = $nome_img;
}

$imagem_temp = @$_FILES['imagem']['tmp_name']; 
$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'pdf'){ 
move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão não permitida!';
	exit();
}



if($id == ""){
	$res = $pdo->prepare("INSERT INTO contas_pagar SET pago = 'Não', data = curDate(), usuario = '$id_usuario', descricao = :descricao, valor = :valor, arquivo = :arquivo");
	$res->bindValue(":descricao", $descricao);
	$res->bindValue(":valor", $valor);
	$res->bindValue(":arquivo", $imagem);
	$res->execute();
}else{

	if($imagem != 'sem-foto.jpg'){
		$res = $pdo->prepare("UPDATE contas_pagar SET  usuario = '$id_usuario', descricao = :descricao, valor = :valor, arquivo = :arquivo WHERE id = :id");
		$res->bindValue(":arquivo", $imagem);
	}else{
		$res = $pdo->prepare("UPDATE contas_pagar SET pago = 'Não', data = curDate(), usuario = '$id_usuario', descricao = :descricao, valor = :valor WHERE id = :id");
	}

	$res->bindValue(":descricao", $descricao);
	$res->bindValue(":valor", $valor);
	$res->bindValue(":id", $id);
	$res->execute();
}



echo 'Salvo com Sucesso!';
?>