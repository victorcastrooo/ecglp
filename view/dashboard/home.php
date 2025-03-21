<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios de Vendas</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Relatórios de Vendas</h1>
        <div class="chart-container">
            <canvas id="marcaMaisVendidaChart"></canvas>
        </div>
        
    </div>

    <script>
        $(document).ready(function() {
    $.getJSON('dashboard/data.php', function(data) {
        console.log(data);

        // Prepare os dados para o gráfico
        var labels = data.marcas.map(function(item) { return item.nomemarca; });
        var values = data.marcas.map(function(item) { return parseFloat(item.total_vendido); });

        var marcaMaisVendidaCtx = document.getElementById('marcaMaisVendidaChart').getContext('2d');
        new Chart(marcaMaisVendidaCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Quantidade Vendida',
                    data: values,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error('Erro ao buscar dados:', textStatus, errorThrown);
    });
});

    </script>
</body>
</html>
