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
        body, html {
            border: none;
            padding: 0;
            margin: 0;
        }

        #menu {
            width: 100%;
            height: 20px;
            padding: 5px 10px;
            font-size: 14px;
            font-family: "微软雅黑";
            left: 10px;
            text-align: center;
        }

        #mapCon {
            width: 100%;
            height: 600px;
            position: relative;
        }

        .ol-popup {
            position: absolute;
            background-color: white;
            -webkit-filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
            filter: drop-shadow(0 1px 4px rgba(0,0,0,0.2));
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #cccccc;
            bottom: 45px;
            left: -50px;
        }

        .ol-popup:after, .ol-popup:before {
            top: 100%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }

        .ol-popup:after {
            border-top-color: white;
            border-width: 10px;
            left: 48px;
            margin-left: -10px;
        }

        .ol-popup:before {
            border-top-color: #cccccc;
            border-width: 11px;
            left: 48px;
            margin-left: -11px;
        }

        .ol-popup-closer {
            text-decoration: none;
            position: absolute;
            top: 2px;
            right: 8px;
        }

        .ol-popup-closer:after {
            content: "✖";
        }

        #popup-content {
            font-size: 14px;
            font-family: "微软雅黑";
        }

        #popup-content .markerInfo {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div id="mapCon">
    <!-- Popup -->
    <div id="popup" class="ol-popup">
        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
        <div id="popup-content">
        </div>
    </div>
</div>
<script type="text/javascript">
    <?php $name = $_GET['name'];
    include('connect_db.php');//链接数据库
    $sql="select * from jingweidu where name='$name'";
    mysqli_query($db,"set names 'utf8'");
    mysqli_query($db,"set character_set_client=utf8");
    mysqli_query($db,"set character_set_results=utf8");
    $result=mysqli_query($db,$sql);
    $row=mysqli_fetch_row($result);
    $data1=$row[1];
    $data2=$row[2];
    $data1json=json_encode($data1);
    $data2json=json_encode($data2);
    if (is_null ( $row )) {
        ?>
        alert("该县不存在！");
        window.location.href="QueryByName.html";
        <?php
    }
    ?>

    var name="<?php echo $name; ?>";
    var longitude=<?php echo $data1json; ?>;
    var latitude=<?php echo $data2json; ?>;
    var longitude1=parseFloat(longitude);
    var latitude1=parseFloat(latitude);

    var nb = [longitude1,latitude1];
    var featuerInfo = {
        geo: nb,
        att: {
            //标注信息的标题内容
            title: name,
            //标注详细信息链接
            titleURL: "http://www.openlayers.org/",
            //标注内容简介
            text: "四川省南充市市辖县，位于四川盆地北部、嘉陵江中游，县境东接仪陇、蓬安，西邻盐亭、梓潼，南靠西充、顺庆，北连阆中、剑阁。县政府驻地南隆镇。\n" +
                "全县幅员面积2235平方公里，耕地91万亩；辖71个乡镇、2个街道办事处，1111个行政村级单位，其中村委会1041个，社区70个，总人口132万（2012年数据）。其中，县城建成区面积30平方公里，常住人口30万。\n" +
                "2012年，南部县地方生产总值209亿元，年均增长14.8%，经济总量位列全省丘陵地区县（市区）前15名；三次产业比重为20.0∶58.7：21.3。主要景点有灵云山、建浩寺、梵音寺等。\n" +
                "2017年10月，南部县通过国家专项评估检查，由四川省人民政府正式批准退出贫困县。",
            //标注的图片
            imgURL: "image/timg.jpg"
        }
    }
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

    map = new ol.Map({
        target: 'mapCon',
        layers: [layer1, layer2],
        view: new ol.View({
            zoom: 4,
            center: nb,
            projection: 'EPSG:4326'
        })
    });

    /**
     * 创建标注样式函数,设置image为图标ol.style.Icon
     * @param {ol.Feature} feature 要素
     */
    var createLabelStyle = function (feature) {
        return new ol.style.Style({
            image: new ol.style.Icon(
                /** @type {olx.style.IconOptions} */
                ({
                    //设置图标点
                    anchor: [0.5, 60],
                    //图标起点
                    anchorOrigin: 'top-right',
                    //指定x值为图标点的x值
                    anchorXUnits: 'fraction',
                    //指定Y值为像素的值
                    anchorYUnits: 'pixels',
                    //偏移
                    offsetOrigin: 'top-right',
                    // offset:[0,10],
                    //图标缩放比例
                    // scale:0.5,
                    //透明度
                    opacity: 0.75,
                    //图标的url
                    src: 'image/map.png'
                })),
            text: new ol.style.Text({
                //位置
                textAlign: 'center',
                //基准线
                textBaseline: 'middle',
                //文字样式
                font: 'normal 14px 微软雅黑',
                //文本内容
                text: feature.get('name'),
                //文本填充样式（即文字颜色）
                fill: new ol.style.Fill({ color: '#aa3300' }),
                stroke: new ol.style.Stroke({ color: '#ffcc33', width: 2 })
            })
        });
    }

    var iconFeature=new ol.Feature({
        geometry:new ol.geom.Point(nb),
        name:name
    });
    iconFeature.setStyle(createLabelStyle(iconFeature));
    var vectorSource = new ol.source.Vector({
        features: [iconFeature]
    });
    //矢量标注图层
    var vectorLayer = new ol.layer.Vector({
        source: vectorSource
    });
    map.addLayer(vectorLayer);

    /**
     * 实现popup的html元素
     */
    var container = document.getElementById('popup');
    var content = document.getElementById('popup-content');
    var closer = document.getElementById('popup-closer');

    /**
     * 在地图容器中创建一个Overlay
     */
    var popup = new ol.Overlay(
        /** @type {olx.OverlayOptions} */
        ({
            //要转换成overlay的HTML元素
            element: container,
            //当前窗口可见
            autoPan: true,
            //Popup放置的位置
            positioning: 'bottom-center',
            //是否应该停止事件传播到地图窗口
            stopEvent: false,
            autoPanAnimation: {
                //当Popup超出地图边界时，为了Popup全部可见，地图移动的速度
                duration: 250
            }
        }));
    map.addOverlay(popup);

    /**
     * 添加关闭按钮的单击事件（隐藏popup）
     * @return {boolean} Don't follow the href.
     */
    closer.onclick = function () {
        //未定义popup位置
        popup.setPosition(undefined);
        //失去焦点
        closer.blur();
        return false;
    };

    /**
     * 动态创建popup的具体内容
     * @param {string} title
     */
    function addFeatrueInfo(info) {
        //新增a元素
        var elementA = document.createElement('a');
        elementA.className = "markerInfo";
        elementA.href = info.att.titleURL;
        //elementA.innerText = info.att.title;
        setInnerText(elementA, info.att.title);
        // 新建的div元素添加a子节点
        content.appendChild(elementA);
        //新增div元素
        var elementDiv = document.createElement('div');
        elementDiv.className = "markerText";
        //elementDiv.innerText = info.att.text;
        setInnerText(elementDiv, info.att.text);
        // 为content添加div子节点
        content.appendChild(elementDiv);
        //新增img元素
        var elementImg = document.createElement('img');
        elementImg.className = "markerImg";
        elementImg.src = info.att.imgURL;
        // 为content添加img子节点
        content.appendChild(elementImg);
    }
    /**
     * 动态设置元素文本内容（兼容）
     */
    function setInnerText(element, text) {
        if (typeof element.textContent == "string") {
            element.textContent = text;
        } else {
            element.innerText = text;
        }
    }

    /**
     * 为map添加点击事件监听，渲染弹出popup
     */
    map.on('click', function (evt) {
        //判断当前单击处是否有要素，捕获到要素时弹出popup
        var feature = map.forEachFeatureAtPixel(evt.pixel, function (feature, layer) { return feature; });
        if (feature) {
            //清空popup的内容容器
            content.innerHTML = '';
            //在popup中加载当前要素的具体信息
            addFeatrueInfo(featuerInfo);
            if (popup.getPosition() == undefined) {
                //设置popup的位置
                popup.setPosition(nb);
            }
        }
    });
    /**
     * 为map添加鼠标移动事件监听，当指向标注时改变鼠标光标状态
     */
    map.on('pointermove', function (e) {
        var pixel = map.getEventPixel(e.originalEvent);
        var hit = map.hasFeatureAtPixel(pixel);
        map.getTargetElement().style.cursor = hit ? 'pointer' : '';
    });
</script>
</body>
</html>