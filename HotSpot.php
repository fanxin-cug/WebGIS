<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>全国贫困县</title>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/ol-debug.js"></script>
    <script src="js/zondyClient.js"></script>
    <link rel="stylesheet" href="js/ol.css">
    <style type="text/css">
        body, html, div, ul, li, iframe, p, img {
            border: none;
            padding: 0;
            margin: 0;
        }

        #mapCon {
            width: 100%;
            top: 60px;
            bottom: 0px;
            position: absolute;
        }

        #menu {
            height: 50px;
            padding: 5px 10px;
            font-size: 14px;
            font-family: "微软雅黑";
            left: 10px;
        }

        #div1 {
            text-align: right;
            float: left;
            display: inline;
            width: 35%;
            height: 100%;
            padding-top: 16px;
        }

        #div2 {
            text-align: left;
            float: left;
            display: inline;
            width: 65%;
            height: 100%;
        }

        .lb {
            margin-left: 5px;
        }
    </style>
</head>
<body>
<div id="menu">
    <div id="div1">
        设置热点图的参数：
    </div>
    <div id="div2">
        <div>
            <label class="lb">热点半径（radius size）：</label><input type="range" id="radius" min="1" max="50" step="1" value="10" />
        </div>
        <div>
            <label class="lb">模糊尺寸（blur size）：</label><input type="range" id="blur" min="1" max="50" step="1" value="15" />
        </div>
    </div>
</div>
<div id="mapCon">
</div>
<script type="text/javascript">
    var blur = document.getElementById('blur');
    var radius = document.getElementById('radius');
    <?php
    include('connect_db.php');//链接数据库
    $sql="select longitude,latitude from jingweidu";
    $result=mysqli_query($db,$sql);
    $data1=array();
    $data2=array();
    while($row=mysqli_fetch_row($result)) {
        $data1[]=$row[0];
        $data2[]=$row[1];
    }
    $data1json=json_encode($data1);
    $data2json=json_encode($data2);
    ?>
    var map;

    var layer1 = new Zondy.Map.TianDiTu({
        ip: "127.0.0.1",
        port: "6163",
        layerType: Zondy.Enum.TiandituType.VEC
    });

    var layer2 = new Zondy.Map.TianDiTu({
        ip: "127.0.0.1",
        port: "6163",
        layerType: Zondy.Enum.TiandituType.CVA
    });
    //设置地图容器放置位置
    var container = document.getElementById('mapCon');
    map = new ol.Map({
        target: container,
        layers: [layer1, layer2],
        view: new ol.View({
            zoom: 4,
            center: [114, 30],
            projection: 'EPSG:4326'
        })
    });

    var X =<?php echo $data1json?>;
    var Y =<?php echo $data2json?>;
    var len = X.length;

    var point=new Array();
    var source= new ol.source.Vector();
    for (var i = 0; i < len; i++) {
        point[i] = new ol.Feature({
            geometry: new ol.geom.Point([X[i], Y[i]])
        });
    }
    for(var i=0;i<len;i++){
        source.addFeature(point[i])
    }
    var vector=new ol.layer.Heatmap({
        source: source,
        //热点半径
        radius: parseInt(radius.value, 6),
        //模糊尺寸
        blur: parseInt(blur.value, 6)
    });
    map.addLayer(vector);
    //为矢量数据源添加addfeature事件监听
    vector.getSource().on('addfeature', function (event) {
            event.feature.set('weight', 5);
        });
    //分别为另个参数设置控件（input）添加事件监听，动态设置热点图的参数
    radius.addEventListener('input', function () {
        //设置热点图层的热点半径
        vector.setRadius(parseInt(radius.value, 10));
    });
    blur.addEventListener('input', function () {
        //设置热点图层的模糊尺寸
        vector.setBlur(parseInt(blur.value, 10));
    });
</script>
</body>
</html>