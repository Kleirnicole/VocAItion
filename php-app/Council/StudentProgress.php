<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Progress Tracker</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: 'Poppins', sans-serif; background: #f8f9fa; margin: 0; padding: 20px; }
    .box { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); max-width: 700px; margin: auto; }
    h1 { color: #1d3557; text-align: center; }
  </style>
</head>
<body>
  <div class="box">
    <h1>Progress Tracker</h1>
    <canvas id="progressChart"></canvas>
    <button onclick="window.location.href='Student-Dashboard.html'">Back</button>
  </div>

  <script>
    const ctx = document.getElementById('progressChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Survey Completed', 'Skills Assessed', 'Career Suggestions'],
        datasets: [{
          label: 'Progress',
          data: [80, 50, 30],
          backgroundColor: ['#1d3557', '#457b9d', '#a8dadc']
        }]
      },
      options: { scales: { y: { beginAtZero: true, max: 100 } } }
    });
  </script>
</body>
</html>
