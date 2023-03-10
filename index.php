<?php
require('db/conexao.php');

//COMANDO PARA DELETAR
// $sql = $pdo->prepare("DELETE FROM clientes WHERE id=?");
// $sql->execute(array(38));

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar, Atualizar e Deletar</title>
    <style>

        .titulo{
            color: purple;
            font
        }
        .tudo{
            text-align: center;
            width: 90%;
            display: flex;
            align-items: center;
            flex-direction: column;
            padding: 30px 30px;
            justify-content: center;
            border-radius: 20px;
            box-shadow: 0px 10px 40px #00000056; 
        }
        table{
            border-collapse: collapse;
            width:100%
        }
        th,td{
            padding: 10px;
            text-align:center;
            border:1px solid #ccc;
        }
        p{
            padding:20px;
            border:1px solid #ccc;
        }
        .oculto{
            display:none;
        }
        .btn-atualizar{
            color: orange;
            
            
        }
        .btn-deletar{
            color: black;
        }
        .tudo > cancelar{
            color: red;
        }
        .salvar{
            color: green;
        }
    </style>
</head>
<body>
    <div class= "tudo">
        <div class= "titulo"><h1>Cadastrar, atualizar ou deletar</h1></div>
        <form id="form_salva" method="post">
        <input type="text" name="nome" placeholder="Digite seu nome" required>
        <input type="email" name="email" placeholder="Digite seu email" required>
        <button type="submit" name="salvar">Salvar</button>
    </form>
        <br>
    <form class= "oculto" id="form_atualiza" method="post">
        <input type="hidden" id="id_editado" name="id_editado" placeholder="ID" required>
        <input type="text" id="nome_editado" name="nome_editado" placeholder="Editar nome" required>
        <input type="email" id="email_editado" name="email_editado" placeholder="Editar email" required>
        <button type="submit" name="atualizar">Atualizar</button>
        <button type="button" id="cancelar" name="cancelar">Cancelar</button>
    </form>

    <form class= "oculto" id="form_deleta" method="post">
    <input type="hidden" id="nome_deleta" name="nome_deleta" placeholder="Editar nome" required>
        <input type="hidden" id="email_deleta" name="email_deleta" placeholder="Editar email" required>
        <input type="hidden" id="id_deleta" name="id_deleta" placeholder="ID" required>
        <b>Tem certeza que deseja deletar cliente <span id="cliente"></span></b>
        <button type="submit" name="deletar">Confirmar</button>
        <button type="button" id="cancelar_deleta" name="cancelar_deleta">Cancelar</button>
    </form>


    <br>

<?php
 
    /*INSERIR UM DADO NO BANCO (MODO SIMPLES)
    $sql = $pdo->prepare("INSERT INTO clientes VALUES (null,'Guilherme','teste@teste.com','09-06-2003')");
    $sql->execute(); */

    //SQL INJECTIO  

    if (isset($_POST['salvar']) && isset ($_POST['nome']) && isset ($_POST['email'])){

        $nome= limparpost ($_POST['nome']);
        $email= limparpost ($_POST['email']);
        $data= date('d-m-Y');

        //VALIDA????O DE CAMPO VAZIO
        if($nome=="" || $nome==null){
            echo "<b style='color:red'>Nome n??o pode ser vazio</b>";
            exit();
        }

        if($email=="" || $email==null){
            echo "<b style='color:red'>Email n??o pode ser vazio</b>";
            exit();
        }

        //VALIDA????ES DE NOME E EMAIL

        //VERIFICAR SE O NOME EST?? CORRETO
        if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
            echo "<b style='color:red'>Somente permitido letras e espa??os em branco para o nome</b>";
            exit();
        }

        //VERIFICAR SE O EMAIL ?? VALIDO
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<b style='color:red'>Formato de email inv??lido</b>" ;
        }

        $sql = $pdo->prepare("INSERT INTO clientes VALUES (null,?,?,?)");
        $sql->execute(array($nome,$email,$data));

        echo "<b style='color:green'>Cliente inserido com sucesso!</b>";
        ;

    }
?>

    <?php
    //PROCESSO DE ATUALIZA????O
    if(isset($_POST['atualizar'])&&($_POST['id_editado'])&&($_POST['nome_editado'])&&($_POST['email_editado'])){
       
        $id =limparpost($_POST['id_editado']);
        $nome =limparpost($_POST['nome_editado']);
        $email =limparpost($_POST['email_editado']);

        if($nome=="" || $nome==null){
            echo "<b style='color:red'>Nome n??o pode ser vazio</b>";
            exit();
        }

        if($email=="" || $email==null){
            echo "<b style='color:red'>Email n??o pode ser vazio</b>";
            exit();
        }

        //VALIDA????ES DE NOME E EMAIL

        //VERIFICAR SE O NOME EST?? CORRETO
        if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
            echo "<b style='color:red'>Somente permitido letras e espa??os em branco para o nome</b>";
            exit();
        }

        //VERIFICAR SE O EMAIL ?? VALIDO
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<b style='color:red'>Formato de email inv??lido</b>" ;
        }
    

        //COMANDO PARA ATUALIZAR
        $sql = $pdo->prepare("UPDATE clientes  SET nome=?, email=? WHERE id=?");
        $sql->execute(array($nome,$email,$id));

        echo"Atualizado ".$sql->rowCount()." registros!";

    }
    ?>

    <?php
    //DELETAR DADOS
    if(isset ($_POST['deletar']) && isset ($_POST['id_deleta']) && isset ($_POST['nome_deleta']) && isset ($_POST['email_deleta'])){
        
        $id =limparpost($_POST['id_deleta']);
        $nome =limparpost($_POST['nome_deleta']);
        $email =limparpost($_POST['email_deleta']);

        //COPMANDO PARA DELETAR
        $sql = $pdo->prepare("DELETE FROM clientes WHERE id=? AND nome=? AND email=?");
        $sql->execute(array($id, $nome, $email));

        echo "Deletado com sucesso!";
    }
    
    ?>

<?php
    //SELECIONAR DADOS DA TABELA SELECT
    // $sql = $pdo->prepare("SELECT * FROM clientes");
    // $sql -> execute ();
    // $dados = $sql->fetchALL();

    $sql = $pdo->prepare("SELECT * FROM clientes ORDER BY nome  LIMIT 10");
    $sql -> execute ();
    $dados = $sql->fetchALL();
    //selecionar filtrando dados da tabela

    // $sql = $pdo->prepare("SELECT * FROM clientes WHERE email = ?");
    // $email = 'teste@teste.com';
    // $sql -> execute (array($email));
    // $dados = $sql->fetchALL();

?>

<?php
    if (count($dados) > 0){
        echo"<br><br><table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>A????es</th>
        </tr>";

        foreach($dados as $chave => $valor){
            echo "<tr>
                    <td>".$valor['id']."</td>
                    <td>".$valor['nome']."</td>
                    <td>".$valor['email']."</td>
                    <td><a href='#' class='btn-atualizar' data-id='".$valor['id']."' data-nome='".$valor['nome']."' data-email='".$valor['email']."'>Atualizar</a> | <a href='#' class='btn-deletar' data-id='".$valor['id']."' data-nome='".$valor['nome']."' data-email='".$valor['email']."'>Deletar</a></td>
                </tr>";
        }

        echo"</table>";
    
    }

    else{
            echo"<p>Nenhum cliente cadastrado";
        }
?>
    
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script>
        $(".btn-atualizar").click(function(){
            var id = $(this).attr('data-id');
            var nome = $(this).attr('data-nome');
            var email = $(this).attr('data-email');

            $('#form_salva').addClass('oculto');
            $('#form_deleta').addClass('oculto');
            $('#form_atualiza').removeClass('oculto');

            $("#id_editado").val(id);
            $("#nome_editado").val(nome);
            $("#email_editado").val(email);
            
            //alert ('O ID ??:'+id+"| nome ??:"+nome+"| email ??:"+email);
        });

        $(".btn-deletar").click(function(){
            var id = $(this).attr('data-id');
            var nome = $(this).attr('data-nome');
            var email = $(this).attr('data-email');

            $("#id_deleta").val(id);
            $("#nome_deleta").val(nome);
            $("#email_deleta").val(email);
            $("#cliente").html(nome);

            $('#form_salva').addClass('oculto');
            $('#form_atualiza').addClass('oculto');
            $('#form_deleta').removeClass('oculto');
            
            //alert ('O ID ??:'+id+"| nome ??:"+nome+"| email ??:"+email);
        });

        $('#cancelar').click(function(){
            $('#form_salva').removeClass('oculto');
            $('#form_atualiza').addClass('oculto');
            $('#form_deleta').addClass('oculto');
        });

        $('#cancelar_deleta').click(function(){
            $('#form_salva').removeClass('oculto');
            $('#form_atualiza').addClass('oculto');
            $('#form_deleta').addClass('oculto');
        });

    </script>
    </div>
</body>
</html>
