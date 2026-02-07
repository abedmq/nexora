/* ============================================
   Nexora - Charts Page JavaScript
   ============================================ */

$(document).ready(function () {

    var purpleColors = ['#7c3aed', '#ec4899', '#3b82f6', '#f59e0b', '#10b981', '#ef4444'];

    // ---- ApexCharts: Line Chart ----
    new ApexCharts(document.querySelector('#lineChart'), {
        series: [{
            name: 'Sales',
            data: [31, 40, 28, 51, 42, 82, 56, 70, 63, 90, 78, 100]
        }, {
            name: 'Visitors',
            data: [11, 32, 45, 32, 34, 52, 41, 55, 48, 65, 60, 72]
        }],
        chart: { type: 'line', height: 300, fontFamily: 'Poppins', toolbar: { show: false } },
        colors: ['#7c3aed', '#ec4899'],
        stroke: { width: 2.5, curve: 'smooth' },
        xaxis: { categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] },
        grid: { borderColor: '#e5e7eb', strokeDashArray: 4 },
        legend: { position: 'top' }
    }).render();

    // ---- ApexCharts: Bar Chart ----
    new ApexCharts(document.querySelector('#barChart'), {
        series: [{
            name: 'Revenue',
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66, 73, 78, 84]
        }, {
            name: 'Profit',
            data: [35, 41, 36, 26, 45, 48, 52, 53, 41, 56, 62, 68]
        }],
        chart: { type: 'bar', height: 300, fontFamily: 'Poppins', toolbar: { show: false } },
        colors: ['#7c3aed', '#a78bfa'],
        plotOptions: { bar: { borderRadius: 6, columnWidth: '50%' } },
        xaxis: { categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] },
        grid: { borderColor: '#e5e7eb', strokeDashArray: 4 },
        legend: { position: 'top' }
    }).render();

    // ---- ApexCharts: Area Chart ----
    new ApexCharts(document.querySelector('#areaChart'), {
        series: [{
            name: 'Users',
            data: [100, 220, 180, 340, 280, 420, 380, 500, 460, 580, 530, 650]
        }],
        chart: { type: 'area', height: 300, fontFamily: 'Poppins', toolbar: { show: false } },
        colors: ['#7c3aed'],
        fill: {
            type: 'gradient',
            gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.05, stops: [0, 90, 100] }
        },
        stroke: { width: 2.5, curve: 'smooth' },
        xaxis: { categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] },
        grid: { borderColor: '#e5e7eb', strokeDashArray: 4 }
    }).render();

    // ---- ApexCharts: Donut Chart ----
    new ApexCharts(document.querySelector('#donutChart'), {
        series: [35, 25, 20, 12, 8],
        chart: { type: 'donut', height: 310, fontFamily: 'Poppins' },
        colors: purpleColors,
        labels: ['Chrome', 'Safari', 'Firefox', 'Edge', 'Other'],
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: { show: true, label: 'Total', fontSize: '14px', fontWeight: 600 }
                    }
                }
            }
        },
        legend: { position: 'bottom' },
        stroke: { width: 3, colors: ['#fff'] }
    }).render();

    // ---- ApexCharts: Mixed Chart ----
    new ApexCharts(document.querySelector('#mixedChart'), {
        series: [{
            name: 'Revenue',
            type: 'column',
            data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
        }, {
            name: 'Cashflow',
            type: 'area',
            data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43, 51]
        }, {
            name: 'Growth Rate',
            type: 'line',
            data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39, 51]
        }],
        chart: { height: 350, fontFamily: 'Poppins', toolbar: { show: false } },
        colors: ['#7c3aed', '#ec4899', '#3b82f6'],
        fill: {
            opacity: [1, 0.3, 1],
            gradient: {
                type: 'vertical',
                opacityFrom: 0.4,
                opacityTo: 0.05
            }
        },
        stroke: { width: [0, 2, 2.5], curve: 'smooth' },
        plotOptions: { bar: { borderRadius: 6, columnWidth: '40%' } },
        xaxis: { categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] },
        grid: { borderColor: '#e5e7eb', strokeDashArray: 4 },
        legend: { position: 'top' },
        yaxis: [
            { title: { text: 'Revenue ($K)' } },
            { opposite: true, title: { text: 'Growth (%)' } }
        ]
    }).render();

    // ---- Chart.js: Radar Chart ----
    new Chart(document.getElementById('radarChart'), {
        type: 'radar',
        data: {
            labels: ['Speed', 'Reliability', 'Comfort', 'Safety', 'Efficiency', 'Design'],
            datasets: [{
                label: 'Product A',
                data: [65, 59, 90, 81, 56, 55],
                borderColor: '#7c3aed',
                backgroundColor: 'rgba(124, 58, 237, 0.15)',
                borderWidth: 2,
                pointBackgroundColor: '#7c3aed'
            }, {
                label: 'Product B',
                data: [28, 48, 40, 19, 96, 27],
                borderColor: '#ec4899',
                backgroundColor: 'rgba(236, 72, 153, 0.15)',
                borderWidth: 2,
                pointBackgroundColor: '#ec4899'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { font: { family: 'Poppins' } } }
            },
            scales: {
                r: {
                    beginAtZero: true,
                    grid: { color: '#e5e7eb' },
                    pointLabels: { font: { family: 'Poppins', size: 12 } }
                }
            }
        }
    });

    // ---- Chart.js: Polar Area Chart ----
    new Chart(document.getElementById('polarChart'), {
        type: 'polarArea',
        data: {
            labels: ['Red', 'Purple', 'Blue', 'Green', 'Yellow'],
            datasets: [{
                data: [11, 16, 7, 14, 9],
                backgroundColor: [
                    'rgba(239, 68, 68, 0.6)',
                    'rgba(124, 58, 237, 0.6)',
                    'rgba(59, 130, 246, 0.6)',
                    'rgba(16, 185, 129, 0.6)',
                    'rgba(245, 158, 11, 0.6)'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { family: 'Poppins' } } }
            },
            scales: {
                r: {
                    beginAtZero: true,
                    grid: { color: '#e5e7eb' }
                }
            }
        }
    });

});
