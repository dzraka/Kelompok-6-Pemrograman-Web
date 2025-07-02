<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Grafik Canvas</title>
  <style>
    body {
      margin: 0;
      background-color: #f0f0f0;
      font-family: Arial, sans-serif;
    }

    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      height: 100vh;
      padding-top: 20px;
      box-sizing: border-box;
    }

    canvas {
      background-color: white;
      border: 1px solid #ccc;
    }

    form {
      margin-top: 20px;
    }

    input[type="text"], input[type="number"] {
      padding: 5px;
      margin-right: 10px;
    }

    button {
      padding: 5px 10px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <canvas id="grafikCanvas" width="700" height="400"></canvas>
    <form id="dataForm">
      <input type="text" id="labelInput" placeholder="Label">
      <input type="number" id="valueInput" placeholder="Value">
      <button type="submit">Add Data</button>
    </form>
  </div>

  <script>
    let labels = ["January", "February", "March", "April", "May"];
    let data = [10, 20, 15, 25, 30];

    const canvas = document.getElementById("grafikCanvas");
    const ctx = canvas.getContext("2d");

    function drawChart() {
      const padding = 40;
      const chartHeight = canvas.height - padding * 2;
      const chartWidth = canvas.width - padding * 2;
      const maxData = Math.max(...data);
      const stepX = chartWidth / (labels.length - 1);
      const numberOfLines = 5;

      ctx.clearRect(0, 0, canvas.width, canvas.height);

      // Latar luar abu-abu
      ctx.fillStyle = "#f0f0f0";
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      // Area grafik putih
      ctx.fillStyle = "#ffffff";
      ctx.fillRect(padding, padding, chartWidth, chartHeight);

      // Garis horizontal dan label Y
      ctx.strokeStyle = "#ddd";
      ctx.lineWidth = 1;
      ctx.fillStyle = "black";
      ctx.font = "12px Arial";
      ctx.textAlign = "right";
      for (let i = 0; i <= numberOfLines; i++) {
        const y = padding + (chartHeight / numberOfLines) * i;
        const value = Math.round(maxData - (maxData / numberOfLines) * i);
        ctx.beginPath();
        ctx.moveTo(padding, y);
        ctx.lineTo(padding + chartWidth, y);
        ctx.stroke();
        ctx.fillText(value, padding - 5, y + 4);
      }

      // Garis vertikal dan label X
      ctx.textAlign = "center";
      for (let i = 0; i < labels.length; i++) {
        const x = padding + stepX * i;
        ctx.beginPath();
        ctx.moveTo(x, padding);
        ctx.lineTo(x, padding + chartHeight);
        ctx.stroke();
        ctx.fillText(labels[i], x, padding + chartHeight + 15);
      }

      // Gambar garis antar titik
      ctx.beginPath();
      ctx.strokeStyle = "blue";
      ctx.lineWidth = 2;

      for (let i = 0; i < data.length; i++) {
        const x = padding + stepX * i;
        const y = padding + chartHeight - (data[i] / maxData * chartHeight);
        if (i === 0) {
          ctx.moveTo(x, y);
        } else {
          ctx.lineTo(x, y);
        }
      }

      ctx.stroke();

      // Titik-titik data
      for (let i = 0; i < data.length; i++) {
        const x = padding + stepX * i;
        const y = padding + chartHeight - (data[i] / maxData * chartHeight);
        ctx.beginPath();
        ctx.fillStyle = "blue";
        ctx.arc(x, y, 4, 0, Math.PI * 2);
        ctx.fill();
      }
    }

    drawChart();

    document.getElementById("dataForm").addEventListener("submit", function(e) {
      e.preventDefault();

      const label = document.getElementById("labelInput").value;
      const value = document.getElementById("valueInput").value;

      if (!label || !value) {
        alert("Label dan Value tidak boleh kosong!");
        return;
      }

      labels.push(label);
      data.push(Number(value));
      drawChart();

      document.getElementById("labelInput").value = "";
      document.getElementById("valueInput").value = "";
    });
  </script>
</body>
</html>
