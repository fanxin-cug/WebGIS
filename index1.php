<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>智慧扶贫系统</title>
    <link type="text/css" rel="stylesheet" href="zhfp/css/style1.css" />
    <script type="text/javascript" src="zhfp/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="zhfp/js/menu.js"></script>
</head>

<body>
<div class="top"></div>
<div id="header">
    <div class="logo">智慧扶贫系统</div>
    <div class="navigation">
        <ul>
            <li>欢迎您！</li>
            <li><?php session_start();echo $_SESSION['name'];?></li>
            <li><a href="change_password.html" target="main">修改密码</a></li>
            <li><a href="exit.php">退出</a></li>
            <li><a href="">返回</a></li>
        </ul>
    </div>
</div>
<div id="content">
    <div class="left_menu">
        <ul id="nav_dot">
            <li>
                <h4 class="M1"><span></span>信息查询</h4>
                <div class="list-item none">
                    <a href='van.html' target="main">查询贫困县</a>
                    <a href='123.php' target="main">全国总览</a>
                    <a href='add.html' target="main">增加贫困县</a>
                    <a href='delete.html' target="main">删除贫困县</a>
                    <a href='QueryAttribute.html' target="main">查询贫困县备注</a>
                    <a href='update.html' target="main">更新贫困县备注</a>
                </div>
            </li>
            <li>
                <h4 class="M2"><span></span>展示分析</h4>
                <div class="list-item none">
                    <a href='QueryByName.html' target="main">贫困县基本信息</a>
                    <a href='HotSpot.php' target="main">热力图</a>
                    <a href='Radar.php' target="main">雷达图</a>
                    <a href='LineChart.html' target="main">折线图</a>
                </div>
            </li>
            <li>
                <h4 class="M6"><span></span>地质资料</h4>
                <div class="list-item none">
                    <a href='layerselect.html' target="main">多图层查看</a>
                    <a href='suiwen.html' target="main">水文资料</a>
                    <a href='http://www.ngac.org.cn/Document/document_cs.aspx?mdidntId=cgdoi.n0001/x00005110.z01_0001' target="main">矿产资料</a>
                </div>
            </li>
            <li>
                <h4 class="M3"><span></span>切换数据源(年份)</h4>
                <div class="list-item none">
                    <a href='' target="">2009(默认)</a>
                    <a href='setdata.html' target="main">2010</a>
                    <a href='setdata.html' target="main">2011</a>
                    <a href='setdata.html' target="main">2012</a>
                    <a href='setdata.html' target="main">2013</a>
                    <a href='setdata.html' target="main">2014</a>
                    <a href='setdata.html' target="main">2015</a>
                </div>
            </li>
        </ul>
    </div>
    <div class="m-right">
        <div class="main">
            <iframe  name="main" src="geodata.html" frameborder="0" scrolling="auto" width="100%" height="100%" ></iframe>
        </div>
    </div>
</div>
<div class="bottom"></div>
<div id="footer"><p>Copyright©  2018 版权所有  来源:<a href="http://www.smaryun.com/dev/world/dev-workbench-934" target="_blank">大佬鼠</a></p></div>
<script>navList(12);</script>
</body>
</html>
