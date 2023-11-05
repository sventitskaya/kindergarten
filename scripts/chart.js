fetch('services/chart-data.php')
    .then(response => response.json())
    .then(data => {
        // Данные, полученные с сервера
        const labels = Object.keys(data);
        const values = Object.values(data);

        // Создайте график
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Количество детей',
                    data: values,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        ticks: {
                            stepSize: 1
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });