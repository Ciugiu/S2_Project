document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('activePopulationsChart').getContext('2d');
    const data = {
        labels: activePopulations.map(population => 
            `${population.student_population_code_ref} - ${population.student_population_period_ref.charAt(0)}${population.student_population_year_ref}`
        ),
        datasets: [{
            data: activePopulations.map(population => population.cnt),
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        },
    };

    new Chart(ctx, config);
});