<?php
$conexao = new mysqli("localhost", "root", "", "academia");
$conexao->set_charset("utf8");

if ($conexao->connect_error) {
    die("Erro ao conectar: " . $conexao->connect_error);
}

if (isset($_GET['del'])) {
    $cpf = $_GET['del'];
    $conexao->query("DELETE FROM alunos WHERE cpf = '$cpf'");
    $conexao->query("DELETE FROM treinos WHERE cpf_aluno = '$cpf'");
    
    header("Location: painel_alunos.php");
    exit;
}

if (isset($_POST['novo_aluno'])) {
    $nome     = $_POST['nome'];
    $cpf      = $_POST['cpf'];
    $plano    = $_POST['plano'];
    $idade    = $_POST['idade'];
    $email    = $_POST['email'];
    $telefone = $_POST['telefone'];

    $check = $conexao->query("SELECT cpf FROM alunos WHERE cpf = '$cpf'");
    if ($check->num_rows > 0) {
        echo "<script>alert('Erro: CPF já cadastrado!');</script>";
    } else {
        $sql = "INSERT INTO alunos (cpf, nome, plano, idade, email, telefone) VALUES ('$cpf', '$nome', '$plano', '$idade', '$email', '$telefone')";
        $conexao->query($sql);
        echo "<script>alert('Aluno cadastrado!'); window.location.href='painel_alunos.php';</script>";
    }
}

if (isset($_POST['atualizar_aluno'])) {
    $cpf_antigo = $_POST['cpf_original']; 
    
    $nome     = $_POST['nome'];
    $cpf      = $_POST['cpf']; 
    $plano    = $_POST['plano'];
    $idade    = $_POST['idade'];
    $email    = $_POST['email'];
    $telefone = $_POST['telefone'];

    $sql = "UPDATE alunos SET 
            nome='$nome', cpf='$cpf', plano='$plano', idade='$idade', email='$email', telefone='$telefone' 
            WHERE cpf='$cpf_antigo'";
    
    if($conexao->query($sql)) {
        echo "<script>alert('Dados atualizados!'); window.location.href='painel_alunos.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar.');</script>";
    }
}

$aluno_edit = null; 
if (isset($_GET['edit'])) {
    $cpf_edit = $_GET['edit'];
    $aluno_edit = $conexao->query("SELECT * FROM alunos WHERE cpf = '$cpf_edit'")->fetch_assoc();
}

$alunos = $conexao->query("SELECT * FROM alunos ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Gerenciar Alunos</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Teko:wght@700&display=swap" rel="stylesheet">

<style>
 
    * { box-sizing: border-box; }
    body { margin: 0; font-family: 'Roboto', sans-serif; background: #0a0a0a; color: #fff; padding-bottom: 50px; }
    
    .back-btn { position: fixed; top: 20px; left: 20px; padding: 10px 20px; background: #333; color: #fff; text-decoration: none; border-radius: 30px; font-weight: bold; z-index: 100; }
    .back-btn:hover { background: #d60000; }

    .container { max-width: 1000px; margin: 80px auto; padding: 30px; background: #141414; border-radius: 15px; border: 1px solid #222; }

    h1 { text-align: center; color: #d60000; font-family: 'Teko', sans-serif; font-size: 3rem; text-transform: uppercase; margin-bottom: 30px; }
    h2 { font-family: 'Teko'; color: #ccc; margin-top: 40px; }

    .form-box { background: #1f1f1f; padding: 25px; border-radius: 10px; border: 1px solid #333; }
    
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    
    input, select { 
        width: 100%; padding: 12px; background: #2a2a2a; border: 1px solid #444; 
        color: #fff; border-radius: 5px; font-size: 1rem; outline: none;
    }
    input:focus, select:focus { border-color: #d60000; }

    .btn-submit { 
        width: 100%; padding: 15px; margin-top: 20px; background: #d60000; color: #fff; 
        font-family: 'Teko'; font-size: 1.5rem; border: none; border-radius: 5px; cursor: pointer; 
    }
    .btn-submit:hover { background: #b30000; }
    
    .btn-cancel { 
        background: #444; margin-top: 10px; display: block; text-align: center; text-decoration: none; color: #fff; padding: 10px; border-radius: 5px;
    }

    /* TABELA */
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #1f1f1f; border-radius: 8px; overflow: hidden; }
    th, td { padding: 15px; text-align: left; border-bottom: 1px solid #333; }
    th { background: #252525; color: #d60000; font-family: 'Teko'; font-size: 1.2rem; text-transform: uppercase; }
    tr:hover { background: #2a2a2a; }

    /* BOTÕES DE AÇÃO NA TABELA */
    .action-btn { padding: 5px 10px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 0.9rem; margin-right: 5px; }
    .edit-btn { background: #0056b3; color: white; }
    .edit-btn:hover { background: #004494; }
    .del-btn { background: #8a0000; color: white; }
    .del-btn:hover { background: #ff0000; }

    @media (max-width: 600px) {
        .form-grid { grid-template-columns: 1fr; }
        table { display: block; overflow-x: auto; }
    }
</style>
</head>
<body>

<a href="index.php" class="back-btn">← Voltar</a>

<div class="container">
    <h1>Painel de Alunos</h1>

    <div class="form-box">
     
        <h3 style="margin-top:0; color:#eee;">
            <?= $aluno_edit ? 'EDITAR ALUNO' : 'NOVO ALUNO' ?>
        </h3>

        <form method="POST">

            <?php if ($aluno_edit): ?>
                <input type="hidden" name="cpf_original" value="<?= $aluno_edit['cpf'] ?>">
            <?php endif; ?>

            <div class="form-grid">
                <input type="text" name="nome" placeholder="Nome Completo" required value="<?= $aluno_edit ? $aluno_edit['nome'] : '' ?>">
                
                <input type="text" name="cpf" placeholder="CPF" maxlength="14" required value="<?= $aluno_edit ? $aluno_edit['cpf'] : '' ?>">
                
                <input type="email" name="email" placeholder="E-mail" required value="<?= $aluno_edit ? $aluno_edit['email'] : '' ?>">
                
                <input type="text" name="telefone" placeholder="Telefone" required value="<?= $aluno_edit ? $aluno_edit['telefone'] : '' ?>">
                
                <input type="number" name="idade" placeholder="Idade" required value="<?= $aluno_edit ? $aluno_edit['idade'] : '' ?>">
                
                <select name="plano">
                    <option value="Silver" <?= ($aluno_edit && $aluno_edit['plano'] == 'Silver') ? 'selected' : '' ?>>Plano Silver</option>
                    <option value="Gold" <?= ($aluno_edit && $aluno_edit['plano'] == 'Gold') ? 'selected' : '' ?>>Plano Gold</option>
                    <option value="Titanium" <?= ($aluno_edit && $aluno_edit['plano'] == 'Titanium') ? 'selected' : '' ?>>Plano Titanium</option>
                </select>
            </div>

            <?php if ($aluno_edit): ?>
                <button type="submit" name="atualizar_aluno" class="btn-submit">SALVAR ALTERAÇÕES</button>
                <a href="painel_alunos.php" class="btn-cancel">Cancelar Edição</a>
            <?php else: ?>
                <button type="submit" name="novo_aluno" class="btn-submit">CADASTRAR ALUNO</button>
            <?php endif; ?>
        </form>
    </div>

    <h2>Lista de Alunos</h2>
    <table>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Plano</th>
            <th>Contato</th>
            <th width="150">Ações</th>
        </tr>

        <?php if($alunos && $alunos->num_rows > 0): ?>
            <?php while($row = $alunos->fetch_assoc()): ?>
            <tr>
                <td><?= $row['nome'] ?></td>
                <td><?= $row['cpf'] ?></td>
                <td style="color: #d60000; font-weight:bold;"><?= $row['plano'] ?></td>
                <td style="font-size: 0.9rem; color:#888;">
                    <?= $row['email'] ?><br>
                    <?= $row['telefone'] ?>
                </td>
                <td>

                    <a href="?edit=<?= $row['cpf'] ?>" class="action-btn edit-btn">Editar</a>
                    <a href="?del=<?= $row['cpf'] ?>" class="action-btn del-btn" onclick="return confirm('Tem certeza?')">X</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align:center; padding:30px;">Nenhum aluno cadastrado.</td></tr>
        <?php endif; ?>
    </table>

</div>

</body>
</html>