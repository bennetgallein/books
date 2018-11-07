<!DOCTYPE html>
<html>
<head>
    { include("_views/include/head.php") }
</head>
<body>
{ include("_views/include/header.php") }
{ include("_views/include/sidebar.php") }
<div class="main-container">
    <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="title">
                            <h4>Monitoring</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Monitoring</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="bg-white pd-20 box-shadow border-radius-5 mb-30">
                <h4 class="mb-30">TS3Cloud</h4>
                <div class="row clearfix">
                    <iframe src="https://bennetgallein.grafana.net/d-solo/N0r7x1Jmz/overwatch?refresh=10s&orgId=1&panelId=5&from=1541514218438&to=1541521418438&var-datasource=TS3Cloud&var-host=ts3cloud&theme=light"
                            class="col-sm-6 col-md-6 col-lg-6 xs-mb-20" frameborder="0"></iframe>
                    <iframe src="https://bennetgallein.grafana.net/d-solo/N0r7x1Jmz/overwatch?refresh=10s&orgId=1&panelId=8&from=1541515060565&to=1541522260565&var-datasource=TS3Cloud&var-host=ts3cloud&theme=light"
                            class="col-sm-6 col-md-6 col-lg-6 xs-mb-20" frameborder="0"></iframe>
                    <iframe src="https://bennetgallein.grafana.net/d-solo/N0r7x1Jmz/overwatch?refresh=10s&orgId=1&panelId=14&from=1541515280872&to=1541522480872&var-datasource=TS3Cloud&var-host=ts3cloud&theme=light"
                            class="col-sm-6 col-md-6 col-lg-6 xs-mb-20" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
{ include("_views/include/script.php") }
</body>
</html>