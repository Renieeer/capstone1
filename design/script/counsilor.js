// LINE CHART
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('lineChart').getContext('2d');

    // Initialize chart with empty datasets
    const lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [], // will hold grade names or times
            datasets: [
                {
                    label: 'Male Total',
                    data: [],
                    borderColor: '#6c7cff',
                    backgroundColor: 'transparent',
                    tension: 0.4
                },
                {
                    label: 'Female Total',
                    data: [],
                    borderColor: '#ff7f50',
                    backgroundColor: 'transparent',
                    tension: 0.4
                },
                {
                    label: 'Combined Total',
                    data: [],
                    borderColor: '#28a745',
                    backgroundColor: 'transparent',
                    tension: 0.4
                }
            ]
        },
        options: {
            plugins: { legend: { display: true }},
            scales: {
                x: { grid: { display: false }},
                y: { grid: { display: false }, beginAtZero: true }
            }
        }
    });

    // Initial calculation
    calculateAllTotals();

    // Populate chart data
    updateChart();

    // Auto-refresh every 30 seconds
    setInterval(() => {
        refreshData();
        calculateAllTotals();
        updateChart();
    }, 30000);

    function refreshData() {
        location.reload(); // or fetch data via AJAX
    }

    function updateChart() {
        const grades = []; // x-axis labels
        const maleTotals = [];
        const femaleTotals = [];
        const combinedTotals = [];

        // Assume your overall totals have data-grade attribute
        document.querySelectorAll('.overall-total-total').forEach(cell => {
            const grade = cell.dataset.grade;
            grades.push(grade);

            const maleCell = document.querySelector(`.overall-male-total[data-grade="${grade}"]`);
            const femaleCell = document.querySelector(`.overall-female-total[data-grade="${grade}"]`);

            const male = parseInt(maleCell?.textContent || 0);
            const female = parseInt(femaleCell?.textContent || 0);
            const total = parseInt(cell.textContent || 0);

            maleTotals.push(male);
            femaleTotals.push(female);
            combinedTotals.push(total);
        });

        // Update chart
        lineChart.data.labels = grades;
        lineChart.data.datasets[0].data = maleTotals;
        lineChart.data.datasets[1].data = femaleTotals;
        lineChart.data.datasets[2].data = combinedTotals;

        lineChart.update();
    }
});
// DONUT CHART
new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [80, 10, 10],
            backgroundColor: ['#4f6ef7', '#f9c74f', '#f9844a']
        }]
    },
    options: {
        cutout: '70%',
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});