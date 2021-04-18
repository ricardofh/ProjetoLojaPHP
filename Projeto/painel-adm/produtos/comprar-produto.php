<?php
require_once("../../conexao.php");
@session_start();

$id_usuario = $_SESSION['id_usuario'];

$fornecedor = $_POST['fornecedor'];
$valor_compra = $_POST['valor_compra'];
$valor_compra = str_replace(',', '.', $valor_compra);
$quantidade = $_POST['quantidade'];

$id = $_POST['id-comprar'];

//VALIDAÇÃO DA QUANTIDADE DE PRODUTOS
if($quantidade == 0){
    echo 'quantidade de produtos invalida';
    exit();
}


//CALCULO DO TOTAL GASTO NA COMPRA DE PRODUTOS
$quantidade_u = $quantidade;
$total_compra = $quantidade * $valor_compra;

// INCREMENTAR PRODUTOS NO ESTOQUE
$query_q = $pdo->query("SELECT * FROM produtos WHERE id = '$id'");
$res_q = $query_q->fetchAll(PDO::FETCH_ASSOC);
$estoque = $res_q[0]['estoque'];
$quantidade += $estoque;

//INSERÇAO NO BANCO DE DADOS
$res = $pdo->prepare("UPDATE produtos SET estoque = :quantidade, fornecedor = :fornecedor, valor_compra = :valor_compra WHERE id = :id");
$res->bindValue(":quantidade", $quantidade);
$res->bindValue(":fornecedor", $fornecedor);
$res->bindValue(":valor_compra", $valor_compra);
$res->bindValue(":id", $id);
$res->execute();

//BANCO DE COMPRAS DE PRODUTOS
$res = $pdo->prepare("INSERT compras SET produto = :produto, quantidade = :quantidade, total = :total, data = curDate(), usuario = :usuario, valor = :valor_compra, fornecedor = :fornecedor, pago = 'Não'");
$res->bindValue(":usuario", $id_usuario);
$res->bindValue(":fornecedor", $fornecedor);
$res->bindValue(":valor_compra", $valor_compra);
$res->bindValue(":total", $total_compra);
$res->bindValue(":quantidade", $quantidade_u);
$res->bindValue(":produto", $id);

$res->execute();
$id_compra = $pdo->lastInsertId();

//BANCO DE CONTAS À PAGAR
$res = $pdo->prepare("INSERT contas_pagar SET vencimento = curDate(), descricao = 'Compra de produtos', valor = :valor, data = curDate(), usuario = :usuario, pago = 'Não', arquivo = 'sem-foto.jpg', id_compra = '$id_compra'");
$res->bindValue(":usuario", $id_usuario);
$res->bindValue(":valor", $total_compra);

$res->execute();

echo 'Salvo com Sucesso!';
?>