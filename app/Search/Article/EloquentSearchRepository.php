<?php

namespace App\Search\Article;

use App\Models\Article;
use App\Search\SearchRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class EloquentSearchRepository implements SearchRepository
{
    public function search(string $query): Collection
    {
        $items = Article::query()
            ->where(fn ($q) => (
            $q->where('body', 'LIKE', "%{$query}%")
                ->orWhere('title', 'LIKE', "%{$query}%")
            ))
            ->get();

        return $this->buildCollection($items);
    }


    private function buildCollection($items): Collection
    {
        $ids = Arr::pluck($items, 'id');

        return Article::findMany($ids)
            ->sortBy(function ($article) use ($ids) {
                return array_search($article->getKey(), $ids);
            });
    }
}
