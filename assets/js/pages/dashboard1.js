// Countdown
$(".counter-down").incrementalCounter({digits:'auto'});

// Donut chart
Morris.Donut({
    element: 'donut',
    data: [
        {value: 256, label: 'صبح', formatted: '256 نفر'},
        {value: 512, label: 'ظهر', formatted: '512 نفر'},
        {value: 1024, label: 'عصر', formatted: '1024 نفر'},
        {value: 2048, label: 'شب', formatted: '2048 نفر'}
    ],
        colors: [
        '#ffbd15',
        '#f55145',
        '#13a2a6',
        '#14B9D6'
    ],
    formatter: function (x, data) { return data.formatted; },
    resize: true
});

// Realtime moris chart
var ret = [];
inititializeData();
function inititializeData() {
    for (var x = 15; x > 0; x--) {
        currentDate = new Date();
        currentDate.setSeconds(currentDate.getSeconds()-x);
        var usefulTime = currentDate.getHours() + ":" + currentDate.getMinutes() + ":" + currentDate.getSeconds();
        ret.push({
            x: usefulTime,
            y: Math.floor(Math.random()*50+25)
        });
    }
    return ret;
}
function data() { 
    var currentDate = new Date();
    var currentTime = currentDate.getHours() + ":" + currentDate.getMinutes() + ":" + currentDate.getSeconds();
    ret.push({
        x: currentTime,
        y: Math.floor(Math.random()*50+25)
    });
    ret.shift();
    return ret;
}
var graph = Morris.Line({
    element: 'realtime',
    data: data(0),
    xkey: 'x',
    ykeys: ['y'],
    labels: ['تعداد کلیک'],
    parseTime: false,
    ymin: 0,
    ymax: 100,
    hideHover: true,
    lineColors: ['#14B9D6']
});
function update() {
    graph.setData(data());
}
setInterval(update, 1000);


// َMap
var map;
var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";
AmCharts.ready(function() {
    map = new AmCharts.AmMap();
    map.imagesSettings = {
        rollOverColor: "#ffbd15",
        rollOverScale: 3,
        selectedScale: 5,
        selectedColor: "#575757"
    };
    map.areasSettings = {
        autoZoom: true,
        rollOverBrightness: 10,
        selectedBrightness: 100,
        unlistedAreasColor: "#14b9d6"
    };
    var dataProvider = {
        mapVar: AmCharts.maps.iranHigh,
        images: [
            {svgPath:targetSVG, zoomLevel:5, scale:0.5, title:"تهران: 21,200,000 تومان", latitude:35.7061, longitude:51.4358},
            {svgPath:targetSVG, zoomLevel:5, scale:0.5, title:"شیراز: 20,750,000 تومان", latitude:29.5, longitude:52.5},
            {svgPath:targetSVG, zoomLevel:5, scale:0.5, title:"یزد: 18,200,000 تومان", latitude:32, longitude:55},
            {svgPath:targetSVG, zoomLevel:5, scale:0.5, title:"مشهد: 15,500,000 تومان", latitude:36.5, longitude:59},
            {svgPath:targetSVG, zoomLevel:5, scale:0.5, title:"تبریز: 14,200,000 تومان", latitude:38.7061, longitude:45},
            {svgPath:targetSVG, zoomLevel:5, scale:0.5, title:"اصفهان: 6,100,000 تومان", latitude:33, longitude:52.4358},
            {svgPath:targetSVG, zoomLevel:5, scale:0.5, title:"بندرعباس: 12,200,000 تومان", latitude:27.5, longitude:56},
            {svgPath:targetSVG, zoomLevel:5, scale:0.5, title:"زاهدان: 13,200,000 تومان", latitude:29, longitude:60.5},
        ]
    };
    map.dataProvider = dataProvider;
    map.write("map");
});

// Kama datepicker initial
var datePickerOptions = {
    placeholder: "روز / ماه / سال",
    twodigit: true,
    closeAfterSelect: true,
    nextButtonIcon: "fa fa-arrow-right",
    previousButtonIcon: "fa fa-arrow-left",
    buttonsColor: "gray",
    markToday: true,
    markHolidays: true,
    highlightSelectedDay: true,
    sync: true
};
kamaDatepicker("kama-datepicker", datePickerOptions);



// Knob with swing animation
$('.knob-animate').each(function() {
    var $this = $(this);
    var val = $this.val();

    $this.knob();
    $({
        value: 0
    }).animate({
        value: val
    }, {
        duration: 2000,
        easing: "swing",
        step: function() {
            $this.val(Math.ceil(this.value)).trigger("change");
        }
    });
});