/* ============================================
   Nexora - Dashboard Charts
   ============================================ */

$(document).ready(function () {

    // ---- Revenue Overview (Area Chart) ----
    var revenueOptions = {
        series: [{
            name: 'Revenue',
            data: [4200, 5800, 4900, 6800, 5200, 7800, 6100, 8200, 7400, 9100, 8600, 10200]
        }, {
            name: 'Expenses',
            data: [2800, 3200, 2900, 3800, 3100, 4200, 3500, 4800, 4100, 5200, 4600, 5800]
        }],
        chart: {
            type: 'area',
            height: 320,
            fontFamily: 'Poppins, sans-serif',
            toolbar: { show: false },
            zoom: { enabled: false }
        },
        colors: ['#7c3aed', '#ec4899'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.05,
                stops: [0, 95, 100]
            }
        },
        dataLabels: { enabled: false },
        stroke: {
            curve: 'smooth',
            width: 2.5
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                style: {
                    colors: '#6b7280',
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return '$' + (val / 1000).toFixed(1) + 'k';
                },
                style: {
                    colors: '#6b7280',
                    fontSize: '12px'
                }
            }
        },
        grid: {
            borderColor: '#e5e7eb',
            strokeDashArray: 4,
            padding: { left: 10, right: 10 }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            fontSize: '13px',
            markers: { radius: 4 }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return '$' + val.toLocaleString();
                }
            }
        }
    };

    var revenueChart = new ApexCharts(document.querySelector('#revenueChart'), revenueOptions);
    revenueChart.render();

    // ---- Traffic Sources (Donut Chart) ----
    var trafficOptions = {
        series: [35, 25, 22, 18],
        chart: {
            type: 'donut',
            height: 240,
            fontFamily: 'Poppins, sans-serif'
        },
        colors: ['#7c3aed', '#ec4899', '#3b82f6', '#f59e0b'],
        labels: ['Direct', 'Social', 'Organic', 'Referral'],
        plotOptions: {
            pie: {
                donut: {
                    size: '70%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '14px',
                            fontWeight: 600,
                            color: '#1f2937',
                            formatter: function () {
                                return '24.5K';
                            }
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: false },
        legend: { show: false },
        stroke: {
            width: 3,
            colors: ['#fff']
        }
    };

    var trafficChart = new ApexCharts(document.querySelector('#trafficChart'), trafficOptions);
    trafficChart.render();

});
