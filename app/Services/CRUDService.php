<?php

namespace App\Services;

use Illuminate\Support\Str;
use Storage;

class CRUDService
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function all()
    {
        return $this->class::all();
    }

    public function userAll($request)
    {
        return $this->class::where('user_id', $request->user()->id);
    }

    public function get($id)
    {
        return $this->class::find($id);
    }

    public function create($request, $user_id = null)
    {
        $data =  $user_id ? array_merge($request->all(), ['user_id' => $user_id]) : $request->all();

        if (!$model = $this->class::create($data)) {
            return false;
        }

        if ($request->hasFile('file')) {
            $this->saveFile($model, $request);
        }

        return $model;
    }

    public function update($request, $id)
    {
        $model = $this->class::find($id);
        if (!$model || !$model->update($request->all())) {
            return false;
        }

        if ($request->hasFile('file')) {
            if ($model->file) {
                $this->deleteFile($model);
            }
            $this->saveFile($model, $request);
        }

        return $model;
    }

    public function delete($id)
    {
        $model = $this->class::find($id);
        return $model && $model->delete();
    }

    protected function saveFile($model, $request)
    {
        $dir = $this->class::FILE_DIR;
        $file = $request->file('file');
        $fileName = Str::slug($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $file->getClientOriginalExtension();

        $file->storeAs(
            "{$dir}/{$model->id}",
            $fileName,
            'public'
        );
        $model->file = $fileName;
        $model->save();
    }

    protected function deleteFile($model)
    {
        $path = $this->class::FILE_DIR . "/{$model->id}/" . $model->file;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
