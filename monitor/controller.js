//var myTree;
//var currentCluster=null;
//function doOnLoad() {
//    myTree = new dhtmlXTreeObject("treeboxbox_tree0", "100%", "100%", 0);
//    myTree.setImagePath("dhtmlxTree/codebase/imgs/dhxtree_skyblue/");
//    myTree.load("tree.xml");
//    myTree.attachEvent("onClick", function (id) {
//        var t = myTree.getItemText(id);
//        currentCluster=t;
//        //alert(currentCluster);
//        chart0.setTitle({"text":t+" cpu"} );
//        chart1.setTitle({"text":t+" disk"} );
//        chart2.setTitle({"text":t+" memory"} );
//        chart3.setTitle({"text":t+" io"} );
//        chart0.series[0].setData([]);
//        chart1.series[0].setData([]);
//        chart2.series[0].setData([]);
//        chart3.series[0].setData([]);
//    });
//}
//var chart;
//function requestData() {
//    var myDate=new Date();
//    var currentTime=myDate.getTime();
//    //alert(currentCluster);
//    if (currentCluster!=null) {
//        var url = 'http://localhost/api.php/api/container/' + currentTime + "/" + currentCluster;
//        $.get(url).then(function (data) {
//            //alert(JSON.stringify(data));
//            var shift0 = chart0.series[0].data.length > 20; // shift if the series is longer than 20
//            var shift1 = chart1.series[0].data.length > 20;
//            var shift2 = chart1.series[0].data.length > 20;
//            var shift3 = chart2.series[0].data.length > 20;
//            // add the point
//            var t1 = parseInt(data[0].cpu);
//            var t2 = parseInt(data[0].disk);
//            var t3 = parseInt(data[0].memory);
//            var t4 = parseInt(data[0].io);
//            chart0.series[0].addPoint({x: currentTime, y: t1}, true, shift0);
//            chart1.series[0].addPoint({x: currentTime, y: t2}, true, shift1);
//            chart2.series[0].addPoint({x: currentTime, y: t3}, true, shift2);
//            chart3.series[0].addPoint({x: currentTime, y: t4}, true, shift3);
//
//        });
//    }
//    setTimeout(requestData, 5000);
//}


var myTree;
var currentCluster=null;
function doOnLoad(){
    myTree = new dhtmlXTreeObject("treeboxbox_tree0", "100%", "100%", 0);
    myTree.setImagePath("dhtmlxTree/codebase/imgs/dhxtree_skyblue/");
    myTree.load("tree.xml");
    myTree.attachEvent("onClick", function (id) {
        var t = myTree.getItemText(id);
        currentCluster=t;
        //alert(currentCluster);
        chart0.setTitle({"text":t+" cpu"} );
        chart1.setTitle({"text":t+" disk"} );
        chart2.setTitle({"text":t+" memory"} );
        chart3.setTitle({"text":t+" io"} );
        chart0.series[0].setData([]);
        chart1.series[0].setData([]);
        chart2.series[0].setData([]);
        chart3.series[0].setData([]);
    });
}
var chart;




function requestData() {
    var myDate=new Date();
    var currentTime=myDate.getTime();
    //alert(currentCluster);
    if (currentCluster!=null) {
        var url = "http://202.38.95.152/test/index.php/1/api/container_now/"+currentCluster;
        $.get(url).then(function (data) {
            //alert(JSON.stringify(data));
            //var shift0 = chart0.series[0].data.length > 20; // shift if the series is longer than 20
            //var shift1 = chart1.series[0].data.length > 20;
            //var shift2 = chart1.series[0].data.length > 20;
            //var shift3 = chart2.series[0].data.length > 20;
            // add the point
            var i,cpu_user,memory_buffer,memory_shared,disk_total,disk_free,pkts_out,pkts_in,bytes_in,bytes_out;
            for (i=0;i<data.cpu.length;i++) {
                if (data.cpu[i].metric_name=="cpu_user"){
                    cpu_user=data.cpu[i].value;
                }
            }
            for (i=0;i<data.memory.length;i++) {
                if (data.memory[i].metric_name=="memory_shared"){
                    memory_shared=data.memory[i].value;
                }
                if (data.memory[i].metric_name=="memory_buffer"){
                    memory_buffer=data.memory[i].value;
                }
            }
            for (i=0;i<data.disk.length;i++) {
                if (data.disk[i].metric_name=="disk_total"){
                    disk_total=data.disk[i].value;
                }
                if (data.disk[i].metric_name=="disk_free"){
                    disk_free=data.disk[i].value;
                }
            }
            for (i=0;i<data.io.length;i++) {
                if (data.io[i].metric_name=="bytes_in"){
                    bytes_in=data.io[i].value;
                }
                if (data.io[i].metric_name=="bytes_out"){
                    bytes_out=data.io[i].value;
                }
            }

            //var t2 = parseInt(data[0].disk);
            //var t3 = parseInt(data[0].memory);
            //var t4 = parseInt(data[0].io);
            chart0.series[0].addPoint({x: currentTime, y: parseInt(cpu_user)}, true, chart0.series[0].data.length > 20);
            chart1.series[0].addPoint({x: currentTime, y: parseInt(disk_free)}, true, chart1.series[0].data.length > 20);
            chart1.series[1].addPoint({x: currentTime, y: parseInt(disk_total)}, true, chart1.series[1].data.length > 20);
            chart2.series[0].addPoint({x: currentTime, y: parseInt(memory_shared)}, true, chart2.series[0].data.length > 20);
            chart2.series[1].addPoint({x: currentTime, y: parseInt(memory_buffer)}, true, chart2.series[1].data.length > 20);
            chart3.series[0].addPoint({x: currentTime, y: parseInt(bytes_in)}, true, chart3.series[0].data.length > 20);
            chart3.series[1].addPoint({x: currentTime, y: parseInt(bytes_out)}, true, chart3.series[1].data.length > 20);

        });
    }
    setTimeout(requestData, 5000);
}


$(document).ready(function () {
    chart0 = new Highcharts.Chart({
        chart: {
            renderTo: 'chart0',
            defaultSeriesType: 'spline',
            events: {
                load: requestData
            }
        },
        title: {
            text: 'cluster'
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150,
            maxZoom: 20 * 1000
        },
        yAxis: {
            minPadding: 0.2,
            maxPadding: 0.2,
            title: {
                text: 'Value',
                margin: 80
            }
        },
        series: [{
            name: 'cpu_user',
            data: []
        }]
    });
    chart1 = new Highcharts.Chart({
        chart: {
            renderTo: 'chart1',
            defaultSeriesType: 'spline',
            events: {
                load: requestData
            }
        },
        title: {
            text: 'cluster'
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150,
            maxZoom: 20 * 1000
        },
        yAxis: {
            minPadding: 0.2,
            maxPadding: 0.2,
            title: {
                text: 'Value',
                margin: 80
            }
        },
        series: [{
            name:'disk_free',
            data:[]
        },{
            name:'disk_total',
            data:[]
        }]
    });
    chart2 = new Highcharts.Chart({
        chart: {
            renderTo: 'chart2',
            defaultSeriesType: 'spline',
            events: {
                load: requestData
            }
        },
        title: {
            text: 'cluster'
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150,
            maxZoom: 20 * 1000
        },

        yAxis: {
            minPadding: 0.2,
            maxPadding: 0.2,
            title: {
                text: 'Value',
                margin: 80
            }
        },
        series: [{
            name:'memory_shared',
            data:[]
        },{
            name:'memory_buffer',
            data:[]
        }]
    });
    chart3 = new Highcharts.Chart({
        chart: {
            renderTo: 'chart3',
            defaultSeriesType: 'spline',
            events: {
                load: requestData
            }
        },
        title: {
            text: 'cluster'
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150,
            maxZoom: 20 * 1000
        },
        yAxis: {
            minPadding: 0.2,
            maxPadding: 0.2,
            title: {
                text: 'Value',
                margin: 80
            }
        },
        series: [{
            name:'bytes_in',
            data:[]
        },{
            name:'bytes_out',
            data:[]
        }]
    });
});

