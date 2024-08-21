<?php

namespace App\Search\Article;

use App\Models\Article;
use App\Search\SearchRepository;
use Elastic\Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class ElasticsearchRepository implements SearchRepository
{
    /** @var Client */
    public Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }


    /**
     * @param string $query
     * @return false|Collection
     */
    public function search(string $query = ''): false|Collection
    {
        $items = $this->searchOnElasticsearch($query);

        return count($items) ? $this->buildCollection($items) : false;
    }

    private function searchOnElasticsearch(string $query = '')
    {
        $model = new Article;

        try {

            $items = $this->elasticsearch->search([
                'index' => $model->getIndex(),
                'type'  => $model->getType(),
                'body' => [
                    'query' => [
                        'multi_match' => [
                            'fields'  => ['title^5', 'body', 'tags'],
                            'query'   => $query,
                        ],
                    ],
                ],
            ]);

            return $items->asArray();


        } catch (\Exception $e) {

            Log::info('Error  REPO ' . $e->getMessage());
            return [];
        }
    }


    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Article::findMany($ids)
            ->sortBy(function ($article) use ($ids) {
                return array_search($article->getKey(), $ids);
            });
    }

}
