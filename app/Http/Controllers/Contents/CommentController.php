<?php

namespace App\Http\Controllers\Contents;

use App\Http\Requests\Contents\CommentRequest;
use App\Models\Contents\{Comment};
use App\Services\Contents\CRUDService;

class CommentController extends ContentController
{
     protected $CRUDService;

     public function __construct()
     {
          $this->CRUDService = new CRUDService(Comment::class);
     }

     public function update(CommentRequest $request, $id)
     {
          $response = $this->CRUDService->update($request, $id);

          if ($response) {
               return $response;
          }
          return  response('', 500);
     }
}
