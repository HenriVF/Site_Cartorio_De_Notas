<?php include 'inc/header.php'; ?>


<h2 class="mb-3">Formulário de contato</h2>
<p>Nos informe o que precisa, e retornaremos o mais breve!</p>


<hr>
<h3>Contato</h3>




<?php
require 'config.php';
$msg = '';


if(isset($_POST['enviar'])){
    $nome = htmlspecialchars($_POST['nome']);
    $email = htmlspecialchars($_POST['email']);
    $assunto = htmlspecialchars($_POST['assunto']);
    $mensagem = htmlspecialchars($_POST['mensagem']);


    if(empty($nome) || empty($email) || empty($assunto) || empty($mensagem)){
        $msg = '<div class="alert alert-danger">Todos os campos são obrigatórios!</div>';
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $msg = '<div class="alert alert-danger">Email inválido!</div>';
    }else{
        //Inserir no banco de dados
        $sql = $pdo->prepare("INSERT INTO mensagens_contato(nome, email, assunto, mensagem) VALUES(?, ?, ?, ?)");
        if($sql -> execute([$nome, $email, $assunto, $mensagem])){
            $msg = '<div class="alert alert-success">Mensagem enviada com sucesso! Obrigado, '.$nome.'.</div>';
        }else{
            $msg = '<div class="alert alert-danger">Erro ao enviar a mensagem. Tente novamente.</div>';
        }
    }
}
?>






<?php echo $msg; ?>


<form method="post" class="mt-3">
    <div class="mt-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" required>
    </div>


    <div class="mt-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>


    <div class="mt-3">
        <label for="assunto" class="form-label">Assunto:</label>
        <input type="text" class="form-control" id="assunto" name="assunto" required>
    </div>


    <div class="mt-3">
        <label for="mensagem" class="form-label">Mensagem:</label>
        <textarea class="form-control" id="mensagem" name="mensagem" rows="5" required></textarea>
    </div>
    <br>
    <button type="submit" name="enviar" class="btn btn-primary">Enviar</button>


</form>


<?php include 'inc/footer.php'; ?>