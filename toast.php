<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Header Fixo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .fixed-header {
                position: fixed;
                top: 0;
                width: 100%;
                background-color: #343a40;
                color: white;
                padding: 15px;
                text-align: center;
                z-index: 1030;
            }

            /* Adiciona espaço para evitar sobreposição do conteúdo */
            .content {
                margin-top: 70px;
            }
        </style>
    </head>
    <body>

        <!-- Header fixo -->
        <div class="fixed-header">
            <p>📌 Meu Header Fixo</p>
        </div>

        <div class="container content">
            <h1>Conteúdo da Página</h1>
            <p>Adicione bastante texto para testar a rolagem.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
            <p style="height: 1000px;">(Mais conteúdo aqui...)</p>
        </div>

        <script>

            $('#myAlert').on('closed.bs.alert', function () {
                // do something…
            })

        </script>
