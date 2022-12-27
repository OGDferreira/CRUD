<?php
//CONFIGURAÇÃO GERAIS
$servidor="localhost";
$usuario="root";
$senha="";
$banco="primeiro_banco";

//CONEXÃO
try{
$pdo = new PDO("mysql:host=$servidor;dbname=$banco",$usuario,$senha);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "banco conectado com sucesso";
}catch(PDOException $erro){
    echo"Falha ao se conectar com o banco";   
}

//FUNÇÃO PARA LIMPAR AS ENTRADAS
function limparpost($dado){
    $dado = trim($dado);
    $dado = stripslashes($dado);
    $dado = htmlspecialchars($dado);
    return $dado;
    }
?>