jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
        let dates = [];
        for (let i = 0; i < 30; i++) {
            let date = new Date();
            date.setDate(date.getDate() - i);
            let dateString = date.toISOString().split('T')[0];
            dates.push(dateString);
        }
        dates = dates.reverse();
        // chart options
        window.ApexCharts &&
            new ApexCharts(document.getElementById('chart-revenue-bg'), {
                chart: {
                    type: 'area',
                    fontFamily: 'inherit',
                    height: 40.0,
                    sparkline: {
                        enabled: true,
                    },
                    animations: {
                        enabled: false,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: 0.16,
                    type: 'solid',
                },
                stroke: {
                    width: 2,
                    lineCap: 'round',
                    curve: 'smooth',
                },
                series: [
                    {
                        name: 'Profits',
                        data: [
                            37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19,
                            46, 39, 62, 51, 35, 41, 67,
                        ],
                    },
                ],
                tooltip: {
                    theme: 'dark',
                },
                grid: {
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                    type: 'datetime',
                },
                yaxis: {
                    labels: {
                        padding: 4,
                    },
                },
                labels: dates,
                colors: [tabler.getColor('primary')],
                legend: {
                    show: false,
                },
            }).render();
        // new clients chart
        function newClientChartRender() {
            window.ApexCharts &&
                new ApexCharts(document.getElementById('chart-new-clients'), {
                    chart: {
                        type: 'line',
                        fontFamily: 'inherit',
                        height: 40.0,
                        sparkline: {
                            enabled: true,
                        },
                        animations: {
                            enabled: false,
                        },
                    },
                    fill: {
                        opacity: 1,
                    },
                    stroke: {
                        width: [2, 1],
                        dashArray: [0, 3],
                        lineCap: 'round',
                        curve: 'smooth',
                    },
                    series: [
                        {
                            name: 'Male',
                            data: [
                                37, 35, 44, 28, 36, 24, 65, 31, 37, 0, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43,
                                4, 46, 39, 62, 51, 35, 41, 67,
                            ],
                        },
                        {
                            name: 'Female',
                            data: [
                                93, 54, 51, 24, 35, 35, 31, 67, 19, 43, 28, 36, 62, 61, 27, 39, 35, 41, 27, 35, 51, 46,
                                62, 37, 44, 53, 41, 65, 39, 37,
                            ],
                        },
                    ],
                    tooltip: {
                        theme: 'dark',
                    },
                    grid: {
                        strokeDashArray: 4,
                    },
                    xaxis: {
                        labels: {
                            padding: 0,
                        },
                        tooltip: {
                            enabled: false,
                        },
                        type: 'datetime',
                    },
                    yaxis: {
                        labels: {
                            padding: 4,
                        },
                    },
                    labels: dates,
                    colors: [tabler.getColor('primary'), tabler.getColor('gray-600')],
                    legend: {
                        show: false,
                    },
                }).render();
        }
        newClientChartRender();

        // active users chart
        window.ApexCharts &&
            new ApexCharts(document.getElementById('chart-active-users'), {
                chart: {
                    type: 'bar',
                    fontFamily: 'inherit',
                    height: 40.0,
                    sparkline: {
                        enabled: true,
                    },
                    animations: {
                        enabled: false,
                    },
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%',
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: 1,
                },
                series: [
                    {
                        name: 'Profits',
                        data: [
                            37, 35, 44, 28, 36, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19,
                            46, 39, 62, 51, 35, 41, 67,
                        ],
                    },
                ],
                tooltip: {
                    theme: 'dark',
                },
                grid: {
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                    type: 'datetime',
                },
                yaxis: {
                    labels: {
                        padding: 4,
                    },
                },
                labels: dates,
                colors: [tabler.getColor('primary')],
                legend: {
                    show: false,
                },
            }).render();

        $.ajax({
            url: '/admin/dashboard/orders-statistic',
            type: 'GET',
            success: function (response) {
                window.ApexCharts &&
                    new ApexCharts(document.getElementById('chart-mentions'), {
                        chart: {
                            type: 'bar',
                            fontFamily: 'inherit',
                            height: 240,
                            parentHeightOffset: 0,
                            toolbar: {
                                show: false,
                            },
                            animations: {
                                enabled: false,
                            },
                            stacked: true,
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '50%',
                            },
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        fill: {
                            opacity: 1,
                        },
                        series: [
                            {
                                name: 'Orders',
                                data: response.orders,
                            },
                            {
                                name: 'Receipts',
                                data: response.receipts,
                            },
                        ],
                        tooltip: {
                            theme: 'dark',
                        },
                        grid: {
                            padding: {
                                top: -20,
                                right: 0,
                                left: -4,
                                bottom: -4,
                            },
                            strokeDashArray: 4,
                            xaxis: {
                                lines: {
                                    show: true,
                                },
                            },
                        },
                        xaxis: {
                            labels: {
                                padding: 0,
                            },
                            tooltip: {
                                enabled: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                            type: 'datetime',
                        },
                        yaxis: {
                            labels: {
                                padding: 4,
                            },
                        },
                        labels: dates,
                        colors: [tabler.getColor('primary'), tabler.getColor('green', 0.8)],
                        legend: {
                            show: false,
                        },
                    }).render();

                window.ApexCharts &&
                    new ApexCharts(document.getElementById('chart-development-activity'), {
                        chart: {
                            type: 'area',
                            fontFamily: 'inherit',
                            height: 192,
                            sparkline: {
                                enabled: true,
                            },
                            animations: {
                                enabled: false,
                            },
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        fill: {
                            opacity: 0.16,
                            type: 'solid',
                        },
                        stroke: {
                            width: 2,
                            lineCap: 'round',
                            curve: 'smooth',
                        },
                        series: [
                            {
                                name: 'Purchases',
                                data: response.orders,
                            },
                        ],
                        tooltip: {
                            theme: 'dark',
                        },
                        grid: {
                            strokeDashArray: 4,
                        },
                        xaxis: {
                            labels: {
                                padding: 0,
                            },
                            tooltip: {
                                enabled: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                            type: 'datetime',
                        },
                        yaxis: {
                            labels: {
                                padding: 4,
                            },
                        },
                        labels: dates,
                        colors: [tabler.getColor('primary')],
                        legend: {
                            show: false,
                        },
                        point: {
                            show: false,
                        },
                    }).render();
            },
        });
    });
})(jQuery);
