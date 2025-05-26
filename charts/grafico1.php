<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donut Chart</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body>
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">Gráfico de DONA</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Agregar Nuevo Elemento al Gráfico</h3>
        </div>
        <form method="POST" action="agregar_elemento.php">
            <div class="card-body">
                <div class="form-group">
                    <label for="nueva_etiqueta">Etiqueta:</label>
                    <input type="text" class="form-control" id="nueva_etiqueta" name="nueva_etiqueta" required>
                </div>
                <div class="form-group">
                    <label for="nuevo_valor">Valor:</label>
                    <input type="number" class="form-control" id="nuevo_valor" name="nuevo_valor" required>
                </div>
                <div class="form-group">
                    <label for="nuevo_color">Color (opcional, en formato #rrggbb):</label>
                    <input type="text" class="form-control" id="nuevo_color" name="nuevo_color" placeholder="#abcdef">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Agregar Elemento</button>
            </div>
        </form>
    </div>

    <?php
    include 'conexion.php';

    try {
        $stmt = $pdo->query("SELECT etiqueta, valor, color FROM datos_grafico");
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $labels = [];
        $data = [];
        $backgroundColors = [];

        foreach ($resultados as $fila) {
            $labels[] = $fila['etiqueta'];
            $data[] = $fila['valor'];
            $backgroundColors[] = $fila['color'] ?? generateRandomColor(); // Si no hay color, genera uno aleatorio
        }

        // Función para generar un color hexadecimal aleatorio
        function generateRandomColor() {
            return '#' . str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
        }

    } catch (PDOException $e) {
        echo "Error al consultar la base de datos: " . $e->getMessage();
        $labels = [];
        $data = [];
        $backgroundColors = [];
    }
    ?>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/chart.js/Chart.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script>
        $(function() {
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            var donutData = {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: <?php echo json_encode($backgroundColors); ?>,
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })
        })
    </script>
</body>

</html>