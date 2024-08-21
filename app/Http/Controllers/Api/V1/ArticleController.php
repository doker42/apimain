<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Search\Article\ElasticsearchRepository;
use App\Search\SearchRepository;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $validated = $request->validated();

        $article = Article::create($validated);

        if ($article) {
            return response()->json([
                'article' => $article
            ], 200);
        }

        return response()->json([
            'message' => __('Failed to create post.')
        ], 500);
    }


    /**
     * Display the specified resource.
     */
    public function search(Request $request, SearchRepository $searchRepository)
    {
        $search = $request->get('search');

        $searchResult = $searchRepository->search($search);

//        if (!$searchResult) {
//            return response()->json([
//                'message' => __('Failed elastic search.')
//            ], 404);
//        }

        return response()->json([
            'search' => $searchResult?: Article::all(),
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
