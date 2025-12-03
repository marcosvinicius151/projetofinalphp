<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrícula - Titanium Fitness</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Teko:wght@700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: #0a0a0a;
            color: #ffffff;
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .page-container {
            width: 100%;
            max-width: 800px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .brand-header {
            font-family: 'Teko', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 2px;
            color: #fff;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .main-title {
            font-family: 'Teko', sans-serif;
            font-size: 4rem;
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: 10px;
            text-align: center;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        .subtitle {
            color: #888;
            margin-bottom: 40px;
            font-size: 1.2rem;
            text-align: center;
        }

        .form-box {
            background-color: #1a1a1a;
            padding: 50px;
            border-radius: 25px;
            border: 1px solid #333;
            width: 100%;
            box-shadow: 0 20px 50px rgba(0,0,0,0.8);
        }

        .input-group {
            margin-bottom: 25px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 10px;
            font-size: 1rem;
            color: #e0e0e0;
            font-weight: 500;
            text-transform: uppercase;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            background-color: #2a2a2a;
            border: 1px solid #444;
            border-radius: 12px;
            color: #fff;
            font-size: 1.1rem;
            font-family: 'Roboto', sans-serif;
            outline: none;
            transition: 0.3s;
        }

        .form-control::placeholder { color: #555; }

        .form-control:focus {
            border-color: #d60000;
            box-shadow: 0 0 10px rgba(214, 0, 0, 0.3);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        select.form-control {
            appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20width%3D%27292.4%27%20height%3D%27292.4%27%3E%3Cpath%20fill%3D%27%23ffffff%27%20d%3D%27M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-13%205.4A17.6%2017.6%200%200%200%200%2087.2c0%205%201.8%209.3%205.4%2013l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%20100.3c3.6-3.6%205.4-7.8%205.4-12.8%200-5-1.8-9.3-5.4-13z%27%2F%3E%3C%2Fsvg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 10px;
        }

        .btn-submit {
            width: 100%;
            margin-top: 15px;
            padding: 20px;
            background-color: #d60000;
            color: #fff;
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
            font-size: 1.4rem;
            text-transform: uppercase;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background-color: #b30000;
            transform: scale(1.02);
        }

        @media (max-width: 600px) {
            .form-box { padding: 30px 20px; }
            .main-title { font-size: 3rem; }
            .form-row { grid-template-columns: 1fr; gap: 0; }
        }
        .back-btn{
        position:absolute;
        top:15px;
        left:15px;
        padding:10px 18px;
        background:#e03636;
        color:#fff;
        text-decoration:none;
        font-weight:bold;
        border-radius:6px;
        transition:0.2s;
        }

        .back-btn:hover{
            background:#ff4545;
        }
    </style>
</head>
<body>
    
    <a href="index.html" class="back-btn">← Voltar</a>

    <div class="page-container">
        <header class="brand-header">TITANIUM FITNESS</header>

        <h1 class="main-title">MATRÍCULA CONCLUÍDA COM SUCESSO</h1>
        <p class="subtitle">Aguarde pela definição dos seus treinos.</p>

    </div>

</body>
</html>
