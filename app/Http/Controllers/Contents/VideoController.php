<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\Video;
use App\Services\Contents\CRUDService;
use App\Http\Requests\Contents\VideoRequest;

class VideoController extends ContentController
{
    protected $CRUDService;

    public function __construct()
    {
        $this->CRUDService = new CRUDService(Video::class);
    }

    public function updateOrCreate(VideoRequest $request, $id = null)
    {
        $response = $id ? $this->CRUDService->update($request, $id) : $this->CRUDService->create($request);
        if ($response) {
            return $response;
        }
        return  response('', 500);
    }
}
