<?php
    require_once("../../conexao.php");

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $nivel = $_POST['nivel'];

    //VERIFICAR SE JA EXISTE EMAIL CADASTRADO NO BANCO
    $query_con = $pdo->prepare("SELECT *from tbl_usuarios WHERE Email = :email");
    $query_con->bindValue(":email", $email);
    $query_con->execute();
    $res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
    if(@count($res_con) > 0){
        echo 'EMAIL JÁ CADASTRADO';
        exit();
    }

    //VERIFICAR SE JA EXISTE CPF CADASTRADO NO BANCO
    $query_con = $pdo->prepare("SELECT *from tbl_usuarios WHERE Cpf = :cpf");
    $query_con->bindValue(":cpf", $cpf);
    $query_con->execute();
    $res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
    if(@count($res_con) > 0){
        echo 'CPF JÁ CADASTRADO';
        exit();
    }

    //INSERÇAO NO BANCO DE DADOS
    $res = $pdo->prepare("INSERT INTO tbl_usuarios SET Nome = :nome, Email = :email, Cpf = :cpf, Senha = :senha, Nivel = :nivel");
    $res->bindValue(":nome", $nome);
    $res->bindValue(":email", $email);
    $res->bindValue(":cpf", $cpf);
    $res->bindValue(":senha", $senha);
    $res->bindValue(":nivel", $nivel);
    $res->execute();

    echo 'Salvo com Sucesso!'
?>