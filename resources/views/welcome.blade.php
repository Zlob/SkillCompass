<!DOCTYPE html>
<html>
    <head>
        <title>SkillCompass</title>
        <meta charset="utf-8">
        <meta name="description" content="Statistic about programming languages and technologies">
        <meta name="viewport" content="width=1024">
        <meta name="csrf-token" content="{{{ Session::token() }}}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,800,800italic">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,300,700">
        <link rel="stylesheet" href="/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/bower_components/bootstrap/dist/js/bootstrap.min.js">
        <link rel="stylesheet" type="text/css" href="/assets/css/app.css">
        <script data-main="assets/js/requirejs-config" src="/assets/bower_components/requirejs/require.js"></script>
    </head>
    <body>
        <nav class="navbar">            
            <div class="container-fluid">
                <div class="collapse navbar-collapse navbar-left" >
                    <ul class="nav navbar-nav nav-pills" id="area-content">
                    </ul>
                </div>  
                <div class="collapse navbar-collapse navbar-right" >
                    <ul class="nav navbar-nav nav-pills">
                        <li><a class="navbar-btn" href="/about">О проекте</a></li>
                    </ul>
                </div>                    
            </div>
        </nav>
        <div class="jumbotron dark-color">
            <div class="logo container">
                <h1 class="main-header">Skill</h1>
                <img class="header-compass-img" src="http://www.snapagency.com/wp-content/uploads/2014/10/compass-icon.png">
                <h1 class="main-header">Compass</h1>
            </div>
            <div class="message container">
                <h2>узнай, чего ты стоишь</h2>
            </div>
        </div>
        <div class="jumbotron-sub light-color">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <span>Свежая статистика по языкам программирования и смежным технологиям за три простых шага</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="main-content" class="container"></div>  
    </body>
</html>
