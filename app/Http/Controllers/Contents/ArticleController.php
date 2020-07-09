<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\Article;
use App\Services\Contents\CRUDService;
use App\Http\Requests\Contents\ArticleRequest;

class ArticleController extends ContentController
{
    protected $CRUDService;

    public function __construct()
    {
        $this->CRUDService = new CRUDService(Article::class);
    }

    public function updateOrCreate(ArticleRequest $request, $id = null)
    {

        $response = $id ? $this->CRUDService->update($request, $id) : $this->CRUDService->create($request);
        if ($response) {
            return $response;
        }
        return  response('', 500);
    }
}
