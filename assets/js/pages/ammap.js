
AmCharts.ready(function() {
    // Create global AmMap object
    var map = new AmCharts.AmMap();
    var dataProvider = {
        mapVar: AmCharts.maps.worldLow,
        getAreasFromMap: true
    };
    map.dataProvider = dataProvider;
    map.language = "fa";
    map.areasSettings = {
        autoZoom: true,
        rollOverBrightness: 10,
        selectedBrightness: 20
    };
    map.smallMap = new AmCharts.SmallMap();
    map.write("global-map");
    
    
    // Create Iran AmMap object
    var map = new AmCharts.AmMap();
    var dataProvider = {
        mapVar: AmCharts.maps.iranHigh,
        getAreasFromMap: true
    };
    map.dataProvider = dataProvider;
    map.language = "fa";
    map.areasSettings = {
        autoZoom: true,
        rollOverBrightness: 10,
        selectedBrightness: 20
    };
    map.smallMap = new AmCharts.SmallMap();
    map.write("fa-iran-map");
    
    
    // Create En global AmMap object
    var map = new AmCharts.AmMap();
    var dataProvider = {
        mapVar: AmCharts.maps.worldLow,
        getAreasFromMap: true
    };
    map.dataProvider = dataProvider;
    map.areasSettings = {
        autoZoom: true,
        color: "#14b9d6",
        rollOverBrightness: 10,
        selectedBrightness: 100
    };
    map.smallMap = new AmCharts.SmallMap();
    map.write("en-map");
});