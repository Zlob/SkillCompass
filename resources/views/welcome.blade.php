<!DOCTYPE html>
<html>
    <head>
        <title>SkillCompass</title>
        <meta charset="utf-8">
        <meta name="description" content="Statistic about programming languages and technologies">
        <meta name="viewport" content="width=1024">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,800,800italic">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,300,700">
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/js/bootstrap.min.js">
    </head>
    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Trebuchet MS','Open Sans',arial,sans-serif;
        }
        
        .navbar {
            margin: 0px;      
        }
        
        .navbar-btn {
            color: #888;
            font-size: 17px;
            text-transform: uppercase;      
        }
        
        .jumbotron{
            background-image: url(/img/black-lozenge.png);
            padding: 60px;
            margin: 0px;
        }
        
        .main-header{
            margin-top: 10px;
            display: inline-block;
            height: 100%;
            vertical-align: middle;
        }
        
        .header-compass-img {
            display: inline-block;
            /*height: 100%;*/
            width: 64px;
            height: 64px;
            vertical-align: middle;
        }
        
        .main-color {
            background-color: #314657;
            color: #fff;
        }       

        .container {
            text-align: center;
            vertical-align: middle;
        }
        
        .jumbotron-sub{
            padding: 20px;
        }      

        .sub-color {
            background-color: #8298AB;
            color: #314657;
        }
        


    </style>
    <body>
        <nav class="navbar">            
            <div class="container-fluid">
                <div class="collapse navbar-collapse navbar-right" >
                    <ul class="nav navbar-nav nav-pills">
                        <li><a class="navbar-btn" href="#">О проекте<span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>                    
            </div>
        </nav>
        <div class="jumbotron main-color">
            <div class="logo container">
                <h1 class="main-header">Skill</h1>
                <img class="header-compass-img" src="http://www.snapagency.com/wp-content/uploads/2014/10/compass-icon.png">
                <h1 class="main-header">Compass</h1>
            </div>
            <div class="message container">
                <h2>узнай, чего ты стоишь</h2>
            </div>
        </div>
        <div class="jumbotron-sub sub-color">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <span>Свежая статистика по языкам программирования и смежным технологиям за три простых шага</span>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
