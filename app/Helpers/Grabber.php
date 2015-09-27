<?php

namespace App\Helpers;


abstract class Grabber implements \Iterator, GrabberInterface
{

    /**
    * текущая позиция итератора
    * @var int
    */
    private $position = 0;

    /**
    * Массив id вакансий
    * @var array
    */
    private $vacancies = [];

    /**
    * класс для выполнения запросов к API
    * @var Request
    */
    private $request;

    /**
    * @param $client
    */
    public function __construct(ApiRequest $request)
    {
        $this->position  = 0;
        $this->request   = $request;
        $this->vacancies = $this->getVacancies();
    }

    /**
    * перемотка итератора на начало списка
    */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
    * получение текущего элемента итератора
    * @return mixed
    */
    public function current()
    {
        return $this->vacancies[$this->position];
    }

    /**
    * получение текущего ключа итератора
    * @return int
    */
    public function key()
    {
        return $this->position;
    }

    /**
    * перевод указателя на следующий элемент
    */
    public function next()
    {
        ++$this->position;
    }

    /**
    * проверка есть ли еще элементы в итераторе
    * @return bool
    */
    public function valid()
    {
        return isset($this->vacancies[$this->position]);
    }

    /**
    * Выполняет запрос к API и возвращает json ответа
    *
    * @param $api
    * @param array $options
    * @return mixed
    */
    protected function getRequestData($api, array $options = [])
    {
        return $this->request->getRequestData($api, $options);
    }

    abstract protected function getVacancies();
    
    abstract public function getVacancyDetails($id);   





}