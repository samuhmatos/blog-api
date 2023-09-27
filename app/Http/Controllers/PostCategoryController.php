<?php

namespace App\Http\Controllers;

use App\Adapters\PaginationAdapter;
use App\Models\PostCategory;
use App\Services\PostCategoryService;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    public function __construct(protected PostCategoryService $postCategoryService)
    {}
    public function index()
    {
        $postCategory = PostCategory::all();

        return response($postCategory);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function paginatePosts(Request $request, string $slug)
    {
        $page =  $request->query('page', 1);
        $perPage = $request->query('per_page', 10);

        return response(PaginationAdapter::toJson($this->postCategoryService->paginatePostsByCategory($slug, $page, $perPage)));
    }

    public function show(PostCategory $postCategory)
    {
        return response($postCategory);
    }

    public function getPopular()
    {
        $categories = $this->postCategoryService->getPopular();
        return response($categories);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
