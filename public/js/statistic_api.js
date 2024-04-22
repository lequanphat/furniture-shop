jQuery.noConflict();
(function ($) {
    $(document).ready(function () {
    })
    $('#statistic_form').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        console.log({ formData });
        // console.log()
        $.ajax({
            url: `/admin/statistics/getstatistic`,
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log({ response });
                window.ApexCharts && (new ApexCharts(document.getElementById('chart-statistic-2'), {
                    chart: {
                      type: "line",
                      fontFamily: 'inherit',
                      height: 240,
                      parentHeightOffset: 0,
                      toolbar: {
                        show: false,
                      },
                      animations: {
                        enabled: false
                      },
                    },
                    fill: {
                      opacity: 1,
                    },
                    stroke: {
                      width: 2,
                      lineCap: "round",
                      curve: "straight",
                    },
                    series: [{
                      name: "Total sold",
                      data: response.solds,
                    }, {
                      name: "Total Revenue",
                      data: response.revenues
                    }],
                    tooltip: {
                      theme: 'dark'
                    },
                    grid: {
                      padding: {
                        top: -20,
                        right: 0,
                        left: -4,
                        bottom: -4
                      },
                      strokeDashArray: 4,
                    },
                    xaxis: {
                      labels: {
                        padding: 0,
                      },
                      tooltip: {
                        enabled: false
                      },
                      type: 'datetime',
                    },
                    yaxis: {
                      labels: {
                        padding: 4
                      },
                    },
                    labels: response.labels,
                    colors: [tabler.getColor("yellow"), tabler.getColor("green"), tabler.getColor("primary")],
                    legend: {
                      show: true,
                      position: 'bottom',
                      offsetY: 12,
                      markers: {
                        width: 10,
                        height: 10,
                        radius: 100,
                      },
                      itemMargin: {
                        horizontal: 8,
                        vertical: 8
                      },
                    },
                  })).render();
            },
            error: function (error) {
                console.log({ error });
            },
        });
    });
    $.ajax({
        url: ` /admin/categories/getall`,
        type: 'GET',
        success: function (response) {
          console.log(response.categories);
          $('#combobox-categories').append(
            ` <option value="-1">All</option>`
        )
          response.categories.forEach((categorie)=>{
            $('#combobox-categories').append(
                ` <option value="${categorie.category_id}">${categorie.category_id}-${categorie.name}</option>`
            )


          });
        },
        error: function (error) {
            console.log(error);
        },
       


    });
    $.ajax({
        url: `/admin/statistics/overviewLast7day`,
        type: 'GET',
        success: function (response) {
          console.log(response);
          window.ApexCharts && (new ApexCharts(document.getElementById('chart-statistic'), {
            chart: {
              type: "line",
              fontFamily: 'inherit',
              height: 240,
              parentHeightOffset: 0,
              toolbar: {
                show: false,
              },
              animations: {
                enabled: false
              },
            },
            fill: {
              opacity: 1,
            },
            stroke: {
              width: 2,
              lineCap: "round",
              curve: "straight",
            },
            series: [{
              name: "Total sold",
              data: response.solds,
            }, {
              name: "Total orders",
              data: response.orders
            }, {
              name: "Total Revenue",
              data: response.revenues
            }],
            tooltip: {
              theme: 'dark'
            },
            grid: {
              padding: {
                top: -20,
                right: 0,
                left: -4,
                bottom: -4
              },
              strokeDashArray: 4,
            },
            xaxis: {
              labels: {
                padding: 0,
              },
              tooltip: {
                enabled: false
              },
              type: 'datetime',
            },
            yaxis: {
              labels: {
                padding: 4
              },
            },
            labels: response.labels,
            colors: [tabler.getColor("yellow"), tabler.getColor("green"), tabler.getColor("primary")],
            legend: {
              show: true,
              position: 'bottom',
              offsetY: 12,
              markers: {
                width: 10,
                height: 10,
                radius: 100,
              },
              itemMargin: {
                horizontal: 8,
                vertical: 8
              },
            },
          })).render();
        },
        error: function (error) {
            console.log(error);
        },
    });
    })(jQuery); 