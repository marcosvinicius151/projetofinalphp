<?php
$conexao = new mysqli("localhost", "root", "", "academia");
$conexao->set_charset("utf8");

// LISTA DE EXERCÍCIOS
$lista_exercicios = [
    'Peito'  => ['Supino Reto', 'Supino Inclinado', 'Crucifixo', 'Peck Deck', 'Flexão'],
    'Costas' => ['Puxada Frente', 'Remada Baixa', 'Remada Curvada', 'Serrote', 'Barra Fixa'],
    'Perna'  => ['Agachamento', 'Leg Press', 'Extensora', 'Flexora', 'Panturrilha'],
    'Ombro'  => ['Desenvolvimento', 'Elevação Lateral', 'Elevação Frontal', 'Encolhimento'],
    'Braços' => ['Rosca Direta', 'Rosca Martelo', 'Tríceps Pulley', 'Tríceps Corda', 'Testa'],
    'Cardio' => ['Esteira 20min', 'Bicicleta 30min', 'Elíptico', 'Abdominal Supra', 'Prancha']
];


if (isset($_POST['salvar'])) {
    $cpf_aluno = $_POST['cpf_aluno'];

  
    $conexao->query("DELETE FROM treinos WHERE cpf_aluno = '$cpf_aluno'");

 
    if (isset($_POST['dias_ativos'])) {
        
        foreach ($_POST['dias_ativos'] as $dia) {

            if (isset($_POST['grupo'][$dia])) {
                $grupo_selecionado = $_POST['grupo'][$dia]; 

                if (isset($_POST['exercicios'][$dia][$grupo_selecionado])) {
                    
                    $exercicios = $_POST['exercicios'][$dia][$grupo_selecionado];
                    
                    $lista_string = implode(", ", $exercicios);
                    
                    $treino_final = strtoupper($grupo_selecionado) . ": " . $lista_string;

                    $sql = "INSERT INTO treinos (cpf_aluno, dia_semana, treino) VALUES ('$cpf_aluno', '$dia', '$treino_final')";
                    $conexao->query($sql);
                }
            }
        }
    }

    echo "<script>alert('Treino salvo!'); window.location.href='painel_treino.php';</script>";
    exit;
}

$alunos = $conexao->query("SELECT cpf, nome FROM alunos ORDER BY nome");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Gerenciar Treinos</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Teko:wght@700&display=swap" rel="stylesheet">

<style>
  
    body { margin: 0; font-family: 'Roboto', sans-serif; background: #0a0a0a; color: #fff; padding-bottom: 50px; }
    
    .back-btn { position: fixed; top: 20px; left: 20px; padding: 10px 20px; background: #333; color: #fff; text-decoration: none; border-radius: 30px; font-weight: bold; }
    .back-btn:hover { background: #d60000; }

    .container { max-width: 800px; margin: 80px auto; padding: 30px; background: #141414; border-radius: 15px; border: 1px solid #222; }

    h1 { text-align: center; color: #d60000; font-family: 'Teko', sans-serif; font-size: 3rem; text-transform: uppercase; }

    
    .dia-box { background: #1f1f1f; margin-bottom: 15px; border-radius: 8px; border: 1px solid #333; overflow: hidden; }
    
    .dia-header { padding: 15px; background: #252525; display: flex; align-items: center; gap: 10px; cursor: pointer; border-bottom: 1px solid #333; }
    .dia-titulo { font-weight: bold; font-size: 1.1rem; }
    
    
    .dia-conteudo { padding: 20px; display: none;  }
    
    
  
    .dia-header:has(.dia-check:checked) + .dia-conteudo {
        display: block;
    }
    
  
    .dia-header:has(.dia-check:checked) {
        background: #2c0b0b; border-color: #d60000;
    }

    
    select { width: 100%; padding: 10px; background: #2a2a2a; color: #fff; border: 1px solid #444; border-radius: 5px; margin-bottom: 15px; }
    
    .lista-exercicios { display: none; background: #141414; padding: 15px; border-radius: 5px; margin-top: 10px; border: 1px solid #333; }
    .item-exercicio { display: inline-block; width: 45%; margin-bottom: 10px; font-size: 0.9rem; color: #ccc; cursor: pointer; }
    .item-exercicio:hover { color: #fff; }

    button { width: 100%; padding: 20px; background: #d60000; color: #fff; font-family: 'Teko'; font-size: 1.5rem; border: none; border-radius: 10px; cursor: pointer; margin-top: 20px; }
    button:hover { background: #b30000; }
</style>

<script>

    function mostrarExercicios(dia, grupoSelecionado) {
 
        var containerDia = document.getElementById('conteudo-' + dia);
        var listas = containerDia.getElementsByClassName('lista-exercicios');
        
        for (var i = 0; i < listas.length; i++) {
            listas[i].style.display = 'none';
        }

        if (grupoSelecionado !== "") {
            var idLista = 'box-' + dia + '-' + grupoSelecionado;
            var elemento = document.getElementById(idLista);
            if(elemento) {
                elemento.style.display = 'block';
            }
        }
    }
</script>

</head>
<body>

<a href="index.php" class="back-btn">← Voltar</a>

<div class="container">
    <h1>Montar Ficha</h1>

    <form method="POST">
        
        <label>Aluno:</label>
        <select name="cpf_aluno" required style="margin-bottom: 30px;">
            <option value="">Selecione...</option>
            <?php while ($a = $alunos->fetch_assoc()): ?>
                <option value="<?= $a['cpf'] ?>"><?= $a['nome'] ?></option>
            <?php endwhile; ?>
        </select>

        <?php 
        $dias = ["Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado", "Domingo"];
        
        foreach ($dias as $dia): 
        ?>
            <div class="dia-box">

                <div class="dia-header">
                    <input type="checkbox" name="dias_ativos[]" value="<?= $dia ?>" class="dia-check">
                    <span class="dia-titulo"><?= $dia ?></span>
                </div>


                <div class="dia-conteudo" id="conteudo-<?= $dia ?>">
                    <label>Foco do Treino:</label>

                    <select name="grupo[<?= $dia ?>]" onchange="mostrarExercicios('<?= $dia ?>', this.value)">
                        <option value="">-- Selecione o Grupo Muscular --</option>
                        
                        <?php foreach ($lista_exercicios as $grupo_nome => $exercicios): ?>
                            <option value="<?= $grupo_nome ?>"><?= $grupo_nome ?></option>
                        <?php endforeach; ?>
                    </select>

                    <?php foreach ($lista_exercicios as $grupo_nome => $exercicios): ?>
                        
                        <div id="box-<?= $dia ?>-<?= $grupo_nome ?>" class="lista-exercicios">
                            <strong>Exercícios de <?= $grupo_nome ?>:</strong><br><br>
                            
                            <?php foreach ($exercicios as $ex): ?>
                                <label class="item-exercicio">
                                    <input type="checkbox" name="exercicios[<?= $dia ?>][<?= $grupo_nome ?>][]" value="<?= $ex ?>">
                                    <?= $ex ?>
                                </label>
                            <?php endforeach; ?>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <button type="submit" name="salvar">SALVAR FICHA</button>
    </form>
</div>

</body>
</html>