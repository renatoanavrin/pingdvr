<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cabeçalho Fixo ao Rolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            max-height: 300px; /* Define altura máxima antes da rolagem */
            overflow-y: auto;  /* Ativa a rolagem vertical */
            position: relative;
        }

        .table-title {
            background: #343a40;
            color: white;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            position: relative;
            z-index: 10;
        }

        .table-title.fixed {
            position: fixed;
            top: 0;
            width: 100%;
            left: 0;
            padding: 10px 20px;
            background: #212529;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

    <div class="container mt-4">
        <div class="table-title" id="tableTitle">📋 Lista de Contatos</div>
        <div class="table-container border mt-2" id="tableContainer">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>João Silva</td><td>joao@email.com</td><td>(11) 99999-0000</td></tr>
                    <tr><td>2</td><td>Maria Souza</td><td>maria@email.com</td><td>(11) 98888-1111</td></tr>
                    <tr><td>3</td><td>Carlos Lima</td><td>carlos@email.com</td><td>(11) 97777-2222</td></tr>
                    <tr><td>4</td><td>Ana Oliveira</td><td>ana@email.com</td><td>(11) 96666-3333</td></tr>
                    <tr><td>5</td><td>Pedro Santos</td><td>pedro@email.com</td><td>(11) 95555-4444</td></tr>
                    <tr><td>6</td><td>Laura Costa</td><td>laura@email.com</td><td>(11) 94444-5555</td></tr>
                    <tr><td>7</td><td>Felipe Rocha</td><td>felipe@email.com</td><td>(11) 93333-6666</td></tr>
                    <tr><td>8</td><td>Sofia Almeida</td><td>sofia@email.com</td><td>(11) 92222-7777</td></tr>
                    <tr><td>9</td><td>Ricardo Mendes</td><td>ricardo@email.com</td><td>(11) 91111-8888</td></tr>
                    <tr><td>10</td><td>Beatriz Ferreira</td><td>beatriz@email.com</td><td>(11) 90000-9999</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const title = document.getElementById("tableTitle");
            const tableContainer = document.getElementById("tableContainer");

            const observer = new IntersectionObserver(entries => {
                if (!entries[0].isIntersecting) {
                    title.classList.add("fixed"); // Fixa o título quando sai da tela
                } else {
                    title.classList.remove("fixed"); // Remove quando volta à tela
                }
            }, { root: null, threshold: 0 });

            observer.observe(tableContainer);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
