<?php
session_start();
if(!isset($_SESSION['usuario_id'])){
    header("location: login.php");
    exit;
}
require 'config.php';
include 'inc/header.php';
?>


<h2>Mensagens de contato</h2>


<?php
$sql = $pdo -> query("SELECT * FROM mensagens_contato ORDER BY criado_em DESC");
$mensagens = $sql -> fetchAll(PDO::FETCH_ASSOC);


if(count($mensagens) == 0){
    echo "<p>Nenhuma mensagem recebida.</p>";
}else{
    echo '<div class="table-responsivo">';
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>#</th><th>Nome</th><th>Email</th><th>Mensagem</th><th>Data</th></tr></thead><tbody>';
    foreach($mensagens as $msg){
        echo '<tr>';
        echo '<td>'.$msg['id'].'</td>';
        echo '<td>'.$msg['nome'].'</td>';
        echo '<td>'.$msg['email'].'</td>';
        echo '<td>'.$msg['assunto'].'</td>';
        echo '<td>'.$msg['mensagem'].'</td>';
        echo '<td>'.$msg['criado_em'].'</td>';
        echo '</tr>';
    }
    echo '</tbody></table></div>';
}


?>
<?php include 'inc/footer.php'; ?>