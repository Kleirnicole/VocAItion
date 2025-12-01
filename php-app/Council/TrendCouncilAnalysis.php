<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trend Analysis - VocAItion</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
    body { background: #f4f6f8; padding: 20px; }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .header h1 { color: #1d3557; }
    .btn {
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      background: #1d3557;
      color: #fff;
      cursor: pointer;
      transition: 0.3s;
    }
    .btn:hover { background: #457b9d; }

    /* Filter Bar */
    .filter-bar {
      margin-bottom: 20px;
      display: flex;
      gap: 10px;
      align-items: center;
      flex-wrap: wrap;
    }
    .filter-bar label {
      font-size: 14px;
      color: #1d3557;
    }
    .filter-bar select, .filter-bar input {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    /* Chart Section */
    .chart-section {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    .chart-card {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .chart-card h3 {
      margin-bottom: 10px;
      color: #1d3557;
    }

    /* Responsive */
    @media (max-width: 900px) {
      .chart-section {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="header">
    <h1>Trend Analysis</h1>
    <button class="btn" onclick="exportTrendReport()">Export Trend Report</button>
  </div>

  <!-- Filter Bar -->
  <div class="filter-bar">
    <label for="dateFilter">Date Range:</label>
    <input type="date" id="startDate">
    <input type="date" id="endDate">

    <label for="sectionFilter">Section:</label>
    <select id="sectionFilter">
      <option value="">All</option>
      <option value="A">Section A</option>
      <option value="B">Section B</option>
    </select>

    <label for="strandFilter">Strand:</label>
    <select id="strandFilter">
      <option value="">All</option>
      <option value="STEM">STEM</option>
      <option value="ABM">ABM</option>
      <option value="HUMSS">HUMSS</option>
    </select>

    <button class="btn" onclick="filterTrends()">Apply Filter</button>
  </div>

  <!-- Chart Section -->
  <div class="chart-section">
    <div class="chart-card">
      <h3>Career Interest Trends</h3>
      <canvas id="careerTrendChart"></canvas>
    </div>
    <div class="chart-card">
      <h3>Batch vs Batch Comparison</h3>
      <canvas id="batchComparisonChart"></canvas>
    </div>
  </div>

  <script>
    // Career Trend Chart
    const ctxCareer = document.getElementById('careerTrendChart').getContext('2d');
    new Chart(ctxCareer, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [
          {
            label: 'Engineering',
            data: [30, 40, 35, 50, 45, 60],
            borderColor: '#1d3557',
            backgroundColor: 'rgba(29,53,87,0.2)',
            tension: 0.3,
            fill: true
          },
          {
            label: 'Business',
            data: [20, 25, 30, 35, 40, 50],
            borderColor: '#e63946',
            backgroundColor: 'rgba(230,57,70,0.2)',
            tension: 0.3,
            fill: true
          }
        ]
      },
      options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    // Batch Comparison Chart
    const ctxBatch = document.getElementById('batchComparisonChart').getContext('2d');
    new Chart(ctxBatch, {
      type: 'bar',
      data: {
        labels: ['STEM', 'ABM', 'HUMSS', 'TVL'],
        datasets: [
          {
            label: 'Batch 2024',
            data: [100, 80, 60, 50],
            backgroundColor: '#457b9d'
          },
          {
            label: 'Batch 2025',
            data: [120, 70, 80, 65],
            backgroundColor: '#a8dadc'
          }
        ]
      },
      options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    function exportTrendReport() {
      alert('Exporting trend report...');
    }

    function filterTrends() {
      alert('Applying filters...');
    }
  </script>
</body>
</html>
