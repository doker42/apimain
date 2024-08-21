<?php

namespace App\Observers;

use Elastic\Elasticsearch\Client;

class ElasticsearchObserver
{
    public Client $elasticsearch;
    public function __construct(Client $elasticsearchClient)
    {
        $this->elasticsearch = $elasticsearchClient;
    }

    public function saved($model): void
    {
        $model->elsIndex($this->elasticsearch);
    }

    public function deleted($model): void
    {
        $model->elsDelete($this->elasticsearch);
    }
}
