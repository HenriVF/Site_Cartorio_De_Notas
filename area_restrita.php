<?php
session_start();
if(!isset($_SESSION['usuario_id'])){
    header("location: login.php");
    exit;
}
require 'config.php';
include 'inc/header.php';




//----------Ações----------
if(isset($_GET['marcar_lida'])){
    $id =intval($_GET['marcar_lida']);
    $sql = $pdo -> prepare("UPDATE mensagens_contato SET lida = 1 WHERE id = ?");
    $sql -> execute([$id]);
    header("location: area_restrita.php");
    exit;
}
if(isset($_GET['excluir'])){
    $id =intval($_GET['excluir']);
    $sql = $pdo -> prepare("DELETE FROM mensagens_contato WHERE id = ?");
    $sql -> execute([$id]);
    header("location: area_restrita.php");
    exit;
}


//----------Buscar mensagens----------
$sql = $pdo -> query("SELECT * FROM mensagens_contato ORDER BY criado_em DESC");
$mensagens = $sql -> fetchAll(PDO::FETCH_ASSOC);


?>
<div class="container py-4">
    <h2 class="mb-3">Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></h2>
    <p class="text-muted">Área restrita - painel de mensagens recebidas.</p>
    <hr>


    <?php if(count($mensagens) == 0): ?>
        <div>
            Nenhuma mensagem recebida até o momento.
        </div>
        <?php else: ?>
            <div class="row row-cols-1 rows-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach($mensagens as $msg): ?>
                    <div class="col">
                        <div class="card shadow-sm border-0 <?php echo($msg['lida'] == 0) ? 'border-warning border-3' : ''; ?>">
                            <div class="card-body">
                                <h5 class="card-title mb-1 d-flex justify-content-between align-items-center">
                                    <span><?php echo htmlspecialchars($msg['assunto']); ?></span>
                                    <?php if($msg['lida'] == 0): ?>
                                        <span class="badge bg-warning text-dark">Nova</span>
                                            <?php else: ?>
                                        <span class="badge bg-secundary">Lida</span>
                                    <?php endif; ?>
                                </h5>
                                <p class="mb-2 text-muted small">
                                    <i class="bi bi-person-fill"></i><?php echo htmlspecialchars($msg['nome']); ?><br>
                                    <i class="bi bi-envelope-fill"></i><?php echo htmlspecialchars($msg['email']); ?>
                                </p>
                                <p class="card-text" style="white-space: pre-wrap;"><?php echo nl2br(htmlspecialchars($msg['mensagem'])); ?></p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <small class="text-muted"><i class="bi bi-clock"></i><?php echo $msg['criado_em']; ?></small>
                                    <div>
                                        <?php if($msg['lida'] == 0): ?>
                                            <a href="?marcar_lida=<?php echo $msg['id']; ?>" class="btn btn-sm btn-success me-1">
                                                <i class="bi bi-check-circle"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="?excluir=<?php echo $msg['id']; ?>" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Deseja realmente excluir esta mensagem?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


        <div class="mt-4 text-end">
            <a href="logout.php" class="btn btn-outline-danger">
                <i class="bi bi-box-arrow-right"></i>Sair
            </a>
        </div>
</div>


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


<?php include 'inc/footer.php'; ?>