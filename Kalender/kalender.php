<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kalender</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
            min-height: 100vh;
        }

        .highlight-today {
            background-color: red;
            color: white;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .header a {
            margin:10px;
            text-decoration: none;
            color: #007bff;
        }

        .header strong {
            margin: 0 10px;
        }

        table {
            width: 500px;
            height: 250px;
        }
    </style>
</head>
<body>
    <?php
        $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('n');
        $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

        if ($bulan < 1) {
            $bulan = 12;
            $tahun--;
        }
        if ($bulan > 12) {
            $bulan = 1;
            $tahun++;
        }

        $nama_bulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        $nama_hari = [
            "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
        ];

        $jumlah_hari = date('t', strtotime("$tahun-$bulan-01"));

        $hari_pertama = date('w', strtotime("$tahun-$bulan-01"));
    ?>
    <div class="header">
        <a href="?bulan=<?= $bulan - 1 ?>&tahun=<?= $tahun ?>">&laquo; Bulan Sebelumnya</a>
        <strong><?php echo $nama_bulan[$bulan-1]." ".$tahun; ?></strong>
        <a href="?bulan=<?= $bulan + 1 ?>&tahun=<?= $tahun ?>">Bulan Berikutnya &raquo;</a>
    </div>

    <table border="1">
        <tr>
            <?php
                foreach($nama_hari as $day) { 
                    echo "<td>$day</td>";
                }
            ?>
        </tr>

        <tr>
            <?php
                for ($i=0; $i < $hari_pertama; $i++) { 
                    echo "<td></td>";
                }

                for ($hari = 1; $hari <= $jumlah_hari; $hari++) {
                    if ($hari == date('j')) {
                        echo "<td class='highlight-today'>$hari</td>";
                    } else {
                        echo "<td>$hari</td>";
                    }

                    if (($hari + $hari_pertama) % 7 == 0) {
                        echo "</tr><tr>";
                    }
                }
            ?>
        </tr>
    </table>
</body>
</html>