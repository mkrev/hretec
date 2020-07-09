<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\Discussion;
use App\Services\Contents\CRUDService;
use App\Http\Requests\Contents\DiscussionRequest;

class DiscussionController extends ContentController
{
    protected $CRUDService;

    public function __construct()
    {
        $this->CRUDService = new CRUDService(Discussion::class);
    }

    public function updateOrCreate(DiscussionRequest $request, $id = null)
    {
        $response = $id ? $this->CRUDService->update($request, $id) : $this->CRUDService->create($request);
        if ($response) {
            return $response;
        }
        return  response('', 500);
    }
}
