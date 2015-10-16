@extends('app')

@section('navbar')
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
@stop

@section('app-navigation')
<div id="navigation"></div>
@stop

@section('content')
<script data-main="assets/js/requirejs-config" src="/assets/bower_components/requirejs/require.js"></script>
<div id="step-content" class="row"></div> 
@stop