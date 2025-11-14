<?php
session_start();
require 'config.php';
$msg = '';


if(isset($_POST['login'])){
    $email = $_POST['email'];
    $senha = $_POST['senha'];


    $sql = $pdo -> prepare("SELECT * FROM usuarios WHERE email = ?");
    $sql -> execute([$email]);
    $usuario = $sql -> fetch(PDO::FETCH_ASSOC);
    if($usuario && password_verify($senha, $usuario['senha'])){
        $_SESSION['usuario_id']=$usuario['id'];
        $_SESSION['usuario_nome']=$usuario['nome'];
        header("Location: area_restrita.php");
        exit;
    }else $msg = "Senha ou Email incorreto!";
}


include 'inc/header.php';
?>


<h2>Login</h2>
<hr>
<form method="post">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>


    <button type="submit" name="login" class="btn btn-primary mt-2">Entrar</button>


</form>
<p><?php echo $msg; ?></p>
<?php include 'inc/footer.php'; ?>