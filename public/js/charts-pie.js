/**
 * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
 */

let tepatWaktu = window.chartData.tepatWaktu;
let tidakTepatWaktu = window.chartData.tidakTepatWaktu;

const pieConfig = {
    type: "doughnut",
    data: {
        datasets: [
            {
                data: [tepatWaktu, tidakTepatWaktu],
                /**
                 * These colors come from Tailwind CSS palette
                 * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
                 */
                backgroundColor: ["#06b6d4", "#f05252"],
                label: "Dataset 1",
            },
        ],
        labels: ["Tepat waktu", "Tidak tepat waktu"],
    },
    options: {
        responsive: true,
        cutoutPercentage: 80,
        /**
         * Default legends are ugly and impossible to style.
         * See examples in charts.html to add your own legends
         *  */
        legend: {
            display: false,
        },
    },
};

// change this to the id of your chart element in HMTL
const pieCtx = document.getElementById("pie");
window.myPie = new Chart(pieCtx, pieConfig);
