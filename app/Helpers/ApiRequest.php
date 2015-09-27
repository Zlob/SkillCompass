<?php

namespace App\Helpers;

use App\Models\Job;

/**
 * Parse HeadHunter jobs
 *
 * @author vamakin
 */
class ApiRequest
{
    /**
    * клиент для выполнения запросов к API
    * @var \Guzzle\Service\Client
    */
    private $client;

    /**
     * Конструктор
     */
    public function __construct($client)
    {
        $this->client = $client;
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

        $response = $this->client->get($api, $headers, $options)->send();
        //todo throw exception if status != 200 and log it
        $result = json_decode($response->getBody(), true);

        return $result;

    }
    
}
