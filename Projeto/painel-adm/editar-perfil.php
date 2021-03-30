<?php
    require_once("../conexao.php");

    $senha = $_POST['senha-perfil'];

    $id = $_POST['id-perfil'];

    
    //EDIÇÃO DE DADOS NO BANCO
    $res = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
    $res->bindValue(":senha", $senha);
    $res->bindValue(":id", $id);
    $res->execute(); 
    
    echo 'Salvo com Sucesso!'
?>