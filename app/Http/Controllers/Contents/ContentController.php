<?php

namespace App\Http\Controllers\Contents;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contents\CommentRequest;

abstract class ContentController extends Controller
{

    public function all()
    {
        return $this->CRUDService->all();
    }

    public function userAll(Request $request)
    {
        return $this->CRUDService->userAll($request);
    }

    public function get($id)
    {
        return $this->CRUDService->get($id) ?: response('', 500);
    }

    public function getLike(Request $request, $id)
    {
        return $this->CRUDService->getLike($request, $id) ?: response('', 500);
    }

    public function edit($id)
    {
        return $this->CRUDService->edit($id) ?: response('', 500);
    }

    public function delete($id)
    {
        return $this->CRUDService->delete($id) ?: response('', 500);
    }

    public function addComment(CommentRequest $request, $id)
    {
        return  $this->CRUDService->addComment($request, $id) ?: response('', 500);
    }

    public function addLike(Request $request, $id)
    {
        return  $this->CRUDService->addLike($request, $id) ?: response('', 500);
    }
}
