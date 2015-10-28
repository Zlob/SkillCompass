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
            <strong>SkillCompass</strong> - проект, призванный помочь веб-разработчикам быть востребованными на рынке труда. Здесь вы найдете статистику популярности той или иной технологии, сможете посмотреть, с какими инструментами её чаще всего используют, а самое главное - найти вакансии, сответствующие вашим навыкам. <strong>SkillCompas</strong> так же поможет оценить, каких навыков вам не хватает, что бы претендовать на более высокую зарплату.
        </p>
        <p>На данный момент, статистика и поиск вакансий доступны только по Москве и Санкт-Петербургу.</p>
        <p>Для поиска и анализа вакансий <strong>SkillCompas</strong> использует открытый <a href='https://api.hh.ru'>API</a> <a href='https://hh.ru'>HeadHunter</a>, без которого проект был бы невозможен. Так же, за помощь в создании сайта хочу выразить балгодарность моим друзьям и коллегам <a href='https://github.com/krustnic'>Krustnic</a> и <a href='http://safonov.pro'>Алексею Сафонову</a> (автор логотипа).</p>
        <p>P.S. Код проекта расположен на <a href="https://github.com/Zlob/SkillCompass">GitHub</a>. Обо всех перебоях в работе сайта, а так же с вопросами и пожеланиями просьба писать в раздел <a href="https://github.com/Zlob/SkillCompass/issues">issues</a>.</p>
    </div>

</div>
@stop
