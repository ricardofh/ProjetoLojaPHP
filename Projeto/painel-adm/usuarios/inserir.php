<?php
require_once("../../conexao.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$senha = $_POST['senha'];

//EVITAR DUPLICIDADE DO CPF E EMAIL
$antigo = $_POST['antigo'];
$antigo2 = $_POST['antigo2'];



//VERIFICAR SE JA EXISTE EMAIL CADASTRADO NO BANCO
if ($antigo2 != $email) {
    $query_con = $pdo->prepare("SELECT * from usuarios WHERE email = :email");
    $query_con->bindValue(":email", $email);
    $query_con->execute();
    $res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
    if (@count($res_con) > 0) {
        echo 'O email do usuário já está cadastrado!';
        exit();
    }
}
//VERIFICAR SE JA EXISTE CPF CADASTRADO NO BANCO
if ($antigo != $cpf) {
    $query_con = $pdo->prepare("SELECT * from usuarios WHERE cpf = :cpf");
    $query_con->bindValue(":cpf", $cpf);
    $query_con->execute();
    $res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
    if (@count($res_con) > 0) {
        echo 'O CPF do usuário já está cadastrado!';
        exit();
    }
}

//INSERÇAO NO BANCO DE DADOS
if ($id == "") {
    $res = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, email = :email, cpf = :cpf, senha = :senha, nivel = :nivel");
    $res->bindValue(":nome", $nome);
    $res->bindValue(":email", $email);
    $res->bindValue(":cpf", $cpf);
    $res->bindValue(":senha", $senha);
    $res->bindValue(":nivel", $nivel);
    $res->execute();
    //EDIÇÃO DE DADOS NO BANCO
} else {
    $res = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, cpf = :cpf, senha = :senha, nivel = :nivel WHERE id = :id");
    $res->bindValue(":nome", $nome);
    $res->bindValue(":email", $email);
    $res->bindValue(":cpf", $cpf);
    $res->bindValue(":senha", $senha);
    $res->bindValue(":nivel", $nivel);
    $res->bindValue(":id", $id);
    $res->execute();
}
echo 'Salvo com Sucesso!';
?>