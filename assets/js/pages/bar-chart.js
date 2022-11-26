Chart.defaults.global.defaultFontFamily = "IranSans";
if($("body").hasClass("dark")){
    Chart.defaults.global.defaultFontColor = "#aab3d9";
}

var randomScalingFactor = function() {
    return Math.round(Math.random() * 300);
};
var randomColorFactor = function() {
    return Math.round(Math.random() * 255);
};
var randomColor = function(opacity) {
    return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.7') + ')';
};

var config1 = {
    type: "bar",
    data: {
        labels: ["فروردین", "اردی بهشت", "خرداد", "تیر", "مرداد", "شهریور"],
        datasets: [{
            backgroundColor: "rgba(151,187,205,0.5)",
            borderColor: "rgba(151,187,205,0.9)",
            borderWidth: 2,
            label: "آمار عملکرد", 
            data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        title:{
            display:true
        },
        hover: {
            mode: "nearest",
            intersect: true
        },
        scales: {
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: "ماه"
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: "مقدار"
                },
                ticks: {
                    suggestedMin: -10,
                    suggestedMax: 250
                },
            }]
        }
    }
};

var config2 = {
    type: "bar",
    data: {
        labels: ["فروردین", "اردی بهشت", "خرداد", "تیر", "مرداد", "شهریور"],
        datasets: [{
            backgroundColor: "rgba(151,187,205,0.5)",
            borderColor: "rgba(151,187,205,0.7)",
            borderWidth: 2,
            label: "شیراز",
            data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
        }, {
            backgroundColor: "rgba(60,205,53,0.5)",
            borderColor: "rgba(60,205,53,0.7)",
            borderWidth: 2,
            label: "تهران",
            data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        title:{
            display:true
        },
        hover: {
            mode: "nearest",
            intersect: true
        },
        scales: {
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: "ماه"
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: "مقدار"
                },
                ticks: {
                    suggestedMin: -10,
                    suggestedMax: 250
                },
            }]
        }
    }
};

var config3 = {
    type: "bar",
    data: {
        labels: ["1392", "1393", "1394", "1395", "1396", "1397"],
        datasets: [{
            backgroundColor: randomColor(),
            borderColor: "#888",
            borderWidth: 1,
            label: "آمار عملکرد",
            data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        title:{
            display:true
        },
        hover: {
            mode: "nearest",
            intersect: true
        },
        scales: {
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: "سال"
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: "مقدار"
                },
                ticks: {
                    suggestedMin: -10,
                    suggestedMax: 250
                }
            }]
        }
    }
};

window.onload = function() {
    var ctx = document.getElementById("bar1").getContext("2d");
    window.bar1 = new Chart(ctx, config1);
    
    var ctx = document.getElementById("bar2").getContext("2d");
    window.bar2 = new Chart(ctx, config2);
    
    var ctx = document.getElementById("bar3").getContext("2d");
    window.bar3 = new Chart(ctx, config3);
};

$("#random-data").click(function() {
    $.each(config3.data.datasets, function(i, dataset) {
        dataset.data = dataset.data.map(function() {
            return randomScalingFactor();
        });
    });

    window.bar3.update();
});