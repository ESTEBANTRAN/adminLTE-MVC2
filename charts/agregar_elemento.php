<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva_etiqueta = $_POST['nueva_etiqueta'];
    $nuevo_valor = $_POST['nuevo_valor'];
    $nuevo_color = $_POST['nuevo_color'];

    try {
        $stmt = $pdo->prepare("INSERT INTO datos_grafico (etiqueta, valor, color) VALUES (:etiqueta, :valor, :color)");
        $stmt->bindParam(':etiqueta', $nueva_etiqueta);
        $stmt->bindParam(':valor', $nuevo_valor, PDO::PARAM_INT);
        $stmt->bindParam(':color', $nuevo_color);
        $stmt->execute();

        header("Location: grafico1.php"); // Redirige de vuelta al gráfico
        exit();
    } catch (PDOException $e) {
        echo "Error al agregar el elemento: " . $e->getMessage();
    }
} else {
    // Si se intenta acceder directamente a este archivo sin POST
    header("Location: grafico1.php");
    exit();
}
?>