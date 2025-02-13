/**
 * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
 */
const barConfig = {
    type: 'bar',
    data: {
        labels: [
            'Pendidikan %',
            'Penelitian %',
            'Pengabdian %',
            'Penunjang %',
        ],
        datasets: [
            {
                label: 'Standar',
                backgroundColor: '#0694a2',
                // borderColor: window.chartColors.red,
                borderWidth: 1,
                data: [100, 100, 100, 100],
            },
            {
                label: 'Ketercapaian',
                backgroundColor: '#7e3af2',
                // borderColor: window.chartColors.blue,
                borderWidth: 1,
                data: categoryPercentages,
            },
        ],
    },
    options: {
        responsive: true,
        legend: {
            display: false,
        },
    },
}

const barsCtx = document.getElementById('bars')
window.myBar = new Chart(barsCtx, barConfig)
