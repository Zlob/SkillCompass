@extends('app')

@section('navbar')
<nav class="navbar">            
    <div class="container-fluid">
        <div class="collapse navbar-collapse navbar-right" >
            <ul class="nav navbar-nav nav-pills">
                <li><a class="navbar-btn" href="/">Главная</a></li>
            </ul>
        </div>                    
    </div>
</nav>
@stop

@section('app-navigation')

@stop

@section('content')
<div class='row'>
    <div class='col-md-8 col-md-offset-2 col-sm-12 about-content'>
        <p>
            <strong>SkillCompass</strong> - проект, призванный помочь веб-разработчикам быть востребованными на рынке труда. Здесь вы найдете статистику популярности той или иной технологии, сможете посмотреть, с какими инструментами её чаще всего используют, а самое главное - найти вакансии, соответствующие вашим навыкам. <strong>SkillCompas</strong> так же поможет оценить, каких навыков вам не хватает, что бы претендовать на более высокую зарплату.
        </p>
        <p>На данный момент, статистика и поиск вакансий доступны только по Москве и Санкт-Петербургу.</p>
        <p>Для поиска и анализа вакансий <strong>SkillCompas</strong> использует открытый <a href='https://api.hh.ru'>API</a> <a href='https://hh.ru'>HeadHunter</a>, без которого проект был бы невозможен. Так же, за помощь в создании сайта хочу выразить благодарность моим друзьям и коллегам <a href='https://github.com/krustnic'>Krustnic</a> (гуру фронтенда) и <a href='https://safonov.pro'>Алексею Сафонову</a> (мастер верстки и автор логотипа).</p>
        <p>P.S. Код проекта расположен на <a href="https://github.com/Zlob/SkillCompass">GitHub</a>. Обо всех перебоях в работе сайта, а так же с вопросами и пожеланиями просьба писать в раздел <a href="https://github.com/Zlob/SkillCompass/issues">issues</a>.</p>
    </div>

    <script data-main="assets/js/requirejs-config-about" src="/assets/bower_components/requirejs/require.js"></script>
</div>
@stop
