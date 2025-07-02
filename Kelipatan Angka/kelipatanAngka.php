<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelipatan</title>
    <style>
        div {
    text-align: center;
}

table {
    border: 1px solid;
    width: 50%;
    margin: auto;
    border-collapse: collapse;
}

th, td {
    border: 1px solid;
}

.table-header {
    background-color: rgba(128, 128, 128, 0.145);
}

.Kelipatan {
    background-color: rgba(0, 255, 94, 0.151);
}

body {
    background-color: #f0f0f0;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.canvas {
    width: 700px;
    margin: 30px auto;
    background: white;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

form {
    margin-bottom: 20px;
    text-align: center;
}

input, button {
    padding: 6px 10px;
    margin: 0 5px;
}

table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
}

table, th, td {
    border: 1px solid #ccc;
}

th {
    background-color: #eee;
}

.green {
    background-color: green;
    color: white;
}

.white {
    background-color: white;
    color: black;
}

    </style>
</head>
<body>
    <div class="canvas">
        <form method="POST" action="">
            <label for="kelipatan">Masukkan Kelipatan :</label>
            <input type="number" id="kelipatan" name="kelipatan" min="1">
            <button type="submit">Kirim</button>
        </form>

        <?php
        $kelipatan = isset($_POST['kelipatan']) ? (int)$_POST['kelipatan'] : 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $kelipatan <= 0) {
            echo "<script>alert('Masukkan angka positif!');</script>";
        }
        ?>

        <h2>Kelipatan dari <?php echo $kelipatan > 0 ? $kelipatan : 'Semua'; ?></h2>

        <table>
            <thead>
                <tr>
                    <th>Angka</th>
                    <th>Kelipatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 1; $i <= 40; $i++) {
                    $class = 'green';
                    if ($kelipatan > 0 && $i % $kelipatan !== 0) {
                        $class = 'white';
                    }
                    echo "<tr><td>$i</td><td class='$class'>$i</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
