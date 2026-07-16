<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Http\Resources\Blog\BlogCollection; 
use App\Http\Resources\Blog\BlogResource;
use App\Services\BlogService;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected BlogService $blogService) {}
    public function index()
    {
        $data = $this->blogService->getBlogs();

        if ($data->isEmpty()) {
            return apiResponce(404, 'Not Found');
        }

        return apiResponce(200, 'Success', new BlogCollection($data));
    }

    public function store(BlogRequest $request)
    {
        $data = $request->validated();

        $blog = $this->blogService->store($data);

        if (!$blog) {
            return apiResponce(400, 'Bad Request');
        }

        return apiResponce(200, 'Success', BlogResource::make($blog));
    }

    public function update(BlogRequest $request, $id)
    {
        $data = $request->validated();

        if (!$this->blogService->update($data, $id)) {
            return apiResponce(400, 'Bad Request');
        }

        $blog = $this->blogService->getBlog($id);

        if (!$blog) {
            return apiResponce(404, 'Not Found');
        }
        return apiResponce(200, 'Success', BlogResource::make($blog));
    }

    public function destroy($id)
    {
        if (!$this->blogService->delete($id)) {
            return apiResponce(400, 'Bad Request');
        }

        return apiResponce(200, 'Success');
    }
}
