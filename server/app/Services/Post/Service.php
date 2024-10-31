<?php

namespace App\Services\Post;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Post\StoreRequest;
use App\Models\Post;

class Service
{
  public function store(array $data, StoreRequest $request)
  {
    $image = $request->file('image');

    // TODO: resize image

    $path = $image->store('images', 'public');

    $data['image'] = env('APP_URL') . ':' . env('APP_PORT') . Storage::url($path);

    return Post::create($data);
  }
}
