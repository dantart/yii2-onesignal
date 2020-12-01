<?php

namespace dantart\onesignal\helpers;


use yii\base\Exception;
use yii\helpers\ArrayHelper;

class Notification extends Request
{
    public $id;
    public $methodName = 'notifications';
    public $endpoint = 'notifications';
    public $filters = [];
    public $createParams;

    public function getAll($params = null)
    {
        $query = ArrayHelper::merge($params, ['app_id' => $this->appId]);

        $response = $this->client->request(
            'GET', $this->endpoint,
            ['query' => $query]
        );

        return json_decode($response->getBody(), true);
    }

    public function getOne()
    {
        $response = $this->client->request(
            'GET', $this->endpoint . '/' . $this->id,
            ['query' => [
                'app_id' => $this->appId
            ]]
        );

        return json_decode($response->getBody(), true);
    }

    public function create($headings, $contents, $options = null)
    {
        $params["headings"] = $headings;
        $params["contents"] = $contents;
        $params["app_id"] = $this->appId;

        $this->createParams = ArrayHelper::merge($options, $params);
        $this->createParams["included_segments"] = isset($this->createParams["included_segments"]) ? $this->createParams["included_segments"] : ["All"];

        return $this;
    }

    public function filter(Array $filter)
    {
        array_push($this->filters, $filter);
        return $this;
    }

    public function operatorOr()
    {
        array_push($this->filters, ["operator" => "OR"]);
        return $this;
    }

    public function send()
    {
        if(end($this->filters) == ["operator" => "OR"])
            throw new Exception('Operator OR in last array position');

        if(!$this->createParams["contents"])
            throw new Exception('Contents parameter is required');

        $this->createParams["filters"] = $this->filters;

        $response = $this->client->request(
            'POST', $this->endpoint,
            ['body' => json_encode($this->createParams)]
        );

        return json_decode($response->getBody(), true);
    }

}