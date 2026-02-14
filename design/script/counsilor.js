// LINE CHART
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: ['10am','11am','12pm','1pm','2pm','3pm','4pm','5pm','6pm','7pm'],
        datasets: [{
            data: [55,30,60,50,85,45,55,35,65,85],
            borderColor: '#6c7cff',
            backgroundColor: 'transparent',
            tension: 0.4
        }]
    },
    options: {
        plugins: { legend: { display: false }},
        scales: {
            x: { grid: { display: false }},
            y: { grid: { display: false }}
        }
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