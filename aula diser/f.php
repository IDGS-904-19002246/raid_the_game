<?php
// Simulación de una base de datos
$items = [
    "Manzana",
    "Banana",
    "Naranja",
    "Mango",
    "Fresa",
    "Kiwi",
    "Uva",
    "Cereza",
    "Piña",
    "Melón"
];

// Manejo de sugerencias si se envía el formulario
$suggestions = [];
if (isset($_POST['query'])) {
    $query = $_POST['query'];
    foreach ($items as $item) {
        if (stripos($item, $query) === 0) {
            $suggestions[] = $item;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autocompletado con PHP</title>
    <style>
        #suggestions {
            border: 1px solid #ccc;
            max-width: 200px;
            margin-top: 5px;
            display: none; /* Ocultar inicialmente */
        }
        #suggestions div {
            padding: 5px;
            cursor: pointer;
        }
        #suggestions div:hover {
            background-color: #f0f0f0;
        }
    </style>
    <script>
        function showSuggestions() {
            const suggestionsDiv = document.getElementById("suggestions");
            suggestionsDiv.style.display = document.querySelector('input[name="query"]').value ? "block" : "none";
        }
    </script>
</head>
<body>
    <h1>Autocompletado con PHP</h1>
    <form method="post">
        <input type="text" name="query" oninput="showSuggestions()" placeholder="Buscar..." autocomplete="off">
    </form>

    <div id="suggestions">
        <?php if (!empty($suggestions)): ?>
            <?php foreach ($suggestions as $suggestion): ?>
                <div onclick="this.parentElement.previousElementSibling.value = '<?php echo htmlspecialchars($suggestion); ?>'; this.parentElement.style.display = 'none';">
                    <?php echo htmlspecialchars($suggestion); ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div>No hay sugerencias</div>
        <?php endif; ?>
    </div>
</body>
</html>
