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
         * клиент для выполнения запросов к API
         * @var \Guzzle\Service\Client
         */
        private $client;

        /**
         * @param $client
         */
        public function __construct($client)
        {
            $this->position  = 0;
            $this->client    = $client;
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
        public function getRequestData($api, array $options = [])
        {
            $headers  = [];

            $response = $this->client->get($api, $headers, $options)->send(); //todo catch exception
            //todo throw exception if status != 200 and log it
            $result = json_decode($response->getBody(), true);

            return $result;

        }
        
        abstract protected function getVacancies();
    

    
}