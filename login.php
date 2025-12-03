<?php

$conexao = new mysqli("localhost", "root", "", "academia");
$conexao->set_charset("utf8");

$treinos = null;
$aluno = null;
$erro = "";

if (isset($_POST['buscar'])) {
    $cpf = $_POST['cpf'];
    $cpf = $conexao->real_escape_string($cpf);

    $aluno = $conexao->query("SELECT nome FROM alunos WHERE cpf = '$cpf'")->fetch_assoc();

    if ($aluno) {
        $treinos = $conexao->query("
            SELECT dia_semana, treino 
            FROM treinos 
            WHERE cpf_aluno = '$cpf'
            ORDER BY FIELD(dia_semana,'Segunda','Terça','Quarta','Quinta','Sexta','Sábado')
        ");
    } else {
        $erro = "CPF não encontrado no sistema.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Treino - Noxus Fitness</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Teko:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-red: #D60000;
            --black: #0f0f0f;
            --dark-gray: #1a1a1a;
            --text-white: #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: var(--black);
            color: #ccc;
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        h1, h2, h3 { font-family: 'Teko', sans-serif; text-transform: uppercase; margin: 0; }
        .text-red { color: var(--primary-red); }
        .white-text { color: var(--text-white); }

        /* HEADER */
        .main-header {
            background-color: #000;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--primary-red);
        }

        /* LOGO CLICÁVEL (AJUSTE NOVO) */
        .logo { 
            font-size: 1.8rem; 
            font-weight: 700; 
            letter-spacing: 1px; 
        }
        
        /* Remove o sublinhado e mantem a cor branca no link da logo */
        .logo a {
            text-decoration: none;
            color: #fff;
            transition: 0.3s;
        }
        .logo a:hover {
            opacity: 0.8; /* Efeito suave ao passar o mouse */
        }
        
        .navbar a {
            color: #fff; text-decoration: none; margin: 0 15px;
            font-weight: 500; font-family: 'Teko'; font-size: 1.3rem; letter-spacing: 1px;
            transition: 0.3s;
        }
        .navbar a:hover { color: var(--primary-red); }

        /* CONTENT */
        .content-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 20px;
        }

        .container {
            width: 100%;
            max-width: 800px;
            text-align: center;
        }

        .page-title {
            font-size: 3.5rem;
            color: #fff;
            margin-bottom: 10px;
            line-height: 1;
        }

        .page-subtitle { margin-bottom: 40px; color: #888; }

        /* SEARCH BOX */
        .search-box {
            background-color: var(--dark-gray);
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #333;
            display: flex;
            gap: 15px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        input[type="text"] {
            flex: 1;
            min-width: 250px;
            padding: 15px;
            background-color: #0a0a0a;
            border: 1px solid #444;
            color: #fff;
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
            border-radius: 5px;
            outline: none;
        }
        input[type="text"]:focus { border-color: var(--primary-red); }

        .btn-search {
            background-color: var(--primary-red);
            color: #fff;
            padding: 15px 30px;
            border: none;
            font-family: 'Teko';
            font-size: 1.4rem;
            font-weight: 700;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-search:hover { background-color: #a30000; transform: scale(1.05); }

        /* TABLE */
        .result-area { margin-top: 50px; animation: fadeIn 0.5s ease; }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--dark-gray);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        th {
            background-color: var(--primary-red);
            color: #fff;
            font-family: 'Teko';
            font-size: 1.4rem;
            padding: 15px;
            text-align: left;
            letter-spacing: 1px;
        }

        td {
            padding: 20px;
            border-bottom: 1px solid #333;
            text-align: left;
            color: #ddd;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: #222; }

        /* EXTRAS */
        .erro-msg {
            background: rgba(214, 0, 0, 0.1);
            color: #ff6b6b;
            padding: 15px;
            border: 1px solid #ff6b6b;
            border-radius: 5px;
            margin-top: 20px;
        }

        .matricula-link { margin-top: 20px; font-size: 0.9rem; }
        .matricula-link a { color: var(--primary-red); font-weight: bold; text-decoration: none; }
        .matricula-link a:hover { text-decoration: underline; }

        footer {
            background-color: #000;
            color: #666;
            text-align: center;
            padding: 20px;
            border-top: 2px solid var(--primary-red);
            margin-top: auto;
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

    <header class="main-header">
        <div class="logo">
            <a href="index.html">NOXUS <span class="text-red">FITNESS</span></a>
        </div>

        <nav class="navbar">
            <a href="index.html">Início</a>
            <a href="index.html#diferenciais">Diferenciais</a>
            <a href="index.html#planos">Planos</a>
        </nav>
        <a href="matricula.php" class="btn-search" style="font-size: 1.1rem; padding: 8px 20px; text-decoration: none;">Matricule-se</a>
    </header>

    <section class="content-section">
        <div class="container">
            
            <h1 class="page-title">CONSULTAR <span class="text-red">TREINO</span></h1>
            <p class="page-subtitle">Digite seu CPF para visualizar sua ficha semanal.</p>

            <form method="POST" class="search-box">
                <input type="text" name="cpf" placeholder="000.000.000-00" required>
                <button type="submit" name="buscar" class="btn-search">BUSCAR</button>
            </form>

            <div class="matricula-link">
                Não encontrou seu cadastro? <a href="matricula.php">Clique aqui para se matricular</a>.
            </div>

            <?php if ($erro): ?>
                <div class="erro-msg"><?= $erro ?></div>
            <?php endif; ?>

            <?php if ($aluno): ?>
                <div class="result-area">
                    <div style="text-align: left; margin-bottom: 10px;">
                        <span style="color: #666;">ALUNO:</span>
                        <h2 style="color: #fff; font-size: 2rem;"><?= $aluno['nome'] ?></h2>
                    </div>

                    <?php if ($treinos && $treinos->num_rows > 0): ?>
                        <table>
                            <tr>
                                <th width="30%">DIA DA SEMANA</th>
                                <th>TREINO</th>
                            </tr>
                            <?php while ($t = $treinos->fetch_assoc()): ?>
                            <tr>
                                <td style="color: var(--primary-red); font-weight: bold;"><?= $t['dia_semana'] ?></td>
                                <td><?= $t['treino'] ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </table>
                    <?php else: ?>
                        <p style="margin-top: 20px;">Nenhum treino cadastrado ainda.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <footer>
        <p>Noxus Fitness &copy; 2025 - NO PAIN NO GAIN.</p>
    </footer>

</body>
</html>