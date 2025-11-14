<?php
session_start();
require 'config.php';
$msg = '';


if(isset($_POST['cadastrar'])){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $sql = $pdo -> prepare("SELECT * FROM usuarios WHERE email = ?");
    $sql -> execute([$email]);
    if($sql -> rowCount() > 0){
        $msg = "Email já cadastrado!";
    }else{
        $sql = $pdo -> prepare("INSERT INTO usuarios (nome, email, senha)VALUES (?,?,?)");
        if($sql -> execute([$nome, $email, $senha])){
            $msg = "Cadastro realizado! Faça o login.";
        }else $msg = "Erro ao cadatrar!";
    }
}




include 'inc/header.php';
?>


<h2>Cadastro de Usuário</h2>
<hr>
<form method="post">
    <input type="text" name="nome" placeholder="Nome" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>


    <button type="submit" name="cadastrar" class="btn btn-primary mt-2">Cadastrar</button>


</form>
<p><?php echo $msg; ?></p>
<?php include 'inc/footer.php'; ?>
