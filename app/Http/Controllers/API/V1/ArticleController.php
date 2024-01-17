<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Article;
use App\Http\Resources\V1\ArticleResource;
use App\Http\Resources\V1\ArticleCollection;
use App\Http\Services\Filters\V1\ArticlesFilter;
use App\Http\Requests\V1\StoreArticleRequest;
use App\Http\Requests\V1\UpdateArticleRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleController extends Controller
{
    private $page_size = 20;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : ResourceCollection
    {
        $elo_query = Article::query();

        // Check logical operator in request query
        $mode = $request->query('mode') ?? 'and';
        if (gettype($mode) != 'string') $mode = 'and';

        // Use filter service for build query filters
        $filter = new ArticlesFilter();
        $filter->queryBuilder($request, $elo_query, $mode);

        return new ArticleCollection(
            $elo_query->paginate($this->page_size)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request) : JsonResponse
    {
        $validated = $request->validated();

        return (new ArticleResource(Article::create($validated)))
            ->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : JsonResponse
    {
        return (new ArticleResource(Article::findOrFail($id)))
            ->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, string $id) : JsonResponse
    {
        $validated = $request->validated();

        $article = Article::findOrFail($id);

        $article->update($validated);
        $article->save();

        return (new ArticleResource($article))
            ->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : JsonResponse
    {
        $article = Article::find($id);
        $article->delete();

        return (new ArticleResource($article))
            ->response();
    }
}
