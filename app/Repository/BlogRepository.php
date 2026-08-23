<?php

namespace App\Repository;

use App\Models\Blog;

class BlogRepository
{
    public function getBlogs()
    {
        return Blog::latest('created_at')->get();
    }

    public function getBlog($id)
    {
        return Blog::find($id);
    }

    public function store($data)
    {
        return Blog::create($data);
    }

    public function update($blog, $data)
    {
        return $blog->update($data);
    }

    public function delete($blog)
    {
        return $blog->delete();
    }
}
