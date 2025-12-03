// Gráfico de barras
const ctxBar = document.getElementById('barChart').getContext('2d');
new Chart(ctxBar, {
  type: 'bar',
  data: {
    labels: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
    datasets: [
      {
        label: 'Esta Semana',
        data: [320, 450, 380, 520, 600, 280, 200],
        backgroundColor: '#00b377'
      },
      {
        label: 'Semana Passada',
        data: [220, 310, 280, 340, 420, 190, 150],
        backgroundColor: '#9b30ff'
      }
    ]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { labels: { color: '#fff' } }
    },
    scales: {
      x: { ticks: { color: '#fff' } },
      y: { ticks: { color: '#fff' } }
    }
  }
});

// Gráfico de pizza
const ctxPie = document.getElementById('pieChart').getContext('2d');
new Chart(ctxPie, {
  type: 'doughnut',
  data: {
    labels: ['Investments', 'Infrastructure', 'Fixed Costs', 'Outros'],
    datasets: [{
      data: [35, 20, 20, 15, 10],
      backgroundColor: [
        '#00b377',
        '#9b30ff',
        '#ff6f61',
        '#ffa600',
        '#36a2eb'
      ]
    }]
  },
  options: {
    plugins: {
      legend: { labels: { color: '#fff' } }
    }
  }
});
