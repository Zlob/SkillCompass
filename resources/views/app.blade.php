<!DOCTYPE html>
<html>
    <head>
        <title>SkillCompass</title>
        <meta charset="utf-8">
        <meta name="description" content="Statistic about programming languages and technologies">
        <meta name="viewport" content="width=1024">
        <meta name="csrf-token" content="{{{ Session::token() }}}">
        <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,800,800italic">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,300,700">
        <link rel="stylesheet" href="/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/bower_components/bootstrap/dist/js/bootstrap.min.js">
        <link rel="stylesheet" type="text/css" href="/assets/css/app.min.css">
        <script type="text/javascript" src="/assets/js/metrics/yandex-metrika.js"></script>
    </head>
    <body>
        <div class="wrap">    
            <div rel="main">
                @yield('navbar')
                <div class="jumbotron">
                    <div class="logo container">
                        <h1 class="main-header">Skill</h1>
                        <img class="header-compass-img" src="http://www.snapagency.com/wp-content/uploads/2014/10/compass-icon.png">
                        <h1 class="main-header">Compass</h1>
                    </div>
                    <div class="message container">
                        <h2>узнай, чего ты стоишь</h2>
                    </div>
                </div>
                <div class="jumbotron-sub">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <span>Свежая статистика по языкам программирования и смежным технологиям в мире веб-разработки</span>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('app-navigation')
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </div>        
        <footer id="footer">
            <div class="container">
                <p class='text-center'><small>© 2015-<?php echo date('Y'); ?> &nbsp <a href="https://github.com/Zlob/">Макин Владислав</a> &nbsp <a href='https://github.com/Zlob/SkillCompass'><img src='assets/img/GitHub-Mark-32px.png'></a>  </small></p>
            </div>
            <!-- Yandex.Metrika counter -->
            <noscript><div><img src="https://mc.yandex.ru/watch/33083803" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
            <!-- /Yandex.Metrika counter -->
        </footer>
    </body>
</html>
