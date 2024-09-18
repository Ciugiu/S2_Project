document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('overallAttendanceChart').getContext('2d');

    const labels = [...new Set(overallAttendance.map(item => item.student_population_code_ref))];
    const periods = [...new Set(overallAttendance.map(item => item.student_population_period_ref + item.student_population_year_ref))];

    // Define a list of colors for the datasets
    const colors = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)'
    ];

    const borderColors = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)'
    ];

    const datasets = periods.map((period, index) => {
        return {
            label: period,
            data: labels.map(label => {
                const item = overallAttendance.find(att => att.student_population_code_ref === label && (att.student_population_period_ref + att.student_population_year_ref) === period);
                return item ? item.percents : 0;
            }),
            backgroundColor: colors[index % colors.length],
            borderColor: borderColors[index % borderColors.length],
            borderWidth: 1
        };
    });

    const data = {
        labels: labels,
        datasets: datasets
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            scales: {
                x: {
                    stacked: false // Disable stacking for x-axis
                },
                y: {
                    stacked: false // Disable stacking for y-axis
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        },
    };

    new Chart(ctx, config);
});