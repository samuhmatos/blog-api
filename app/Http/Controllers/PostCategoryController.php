<?php

namespace App\Http\Controllers;

use App\Adapters\PaginationAdapter;
use App\DTOs\PostCategory\CreatePostCategoryDTO;
use App\Http\Requests\PostCategory\CreatePostCategoryRequest;
use App\Http\Requests\PostCategory\UpdatePostCategoryRequest;
use App\Models\PostCategory;
use App\Services\PostCategoryService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostCategoryController extends Controller
{
    public function __construct(
        protected PostCategoryService $service
    ){}

    public function index(Request $request){
        $categories = PostCategory::all();

        return response($categories);
    }

    public function paginate(Request $request)
    {
        $page =  $request->query('page', 1);
        $perPage = $request->query('per_page', 10);
        $is_trash = $request->query('is_trash', false);
        $search = $request->query('search', null);


        return response(PaginationAdapter::toJson($this->service->paginate(
            page: $page,
            perPage: $perPage,
            isTrash: $is_trash,
            search: $search
        )));
    }

    public function store(CreatePostCategoryRequest $request)
    {
        $postCategory = $this->service->store(
            new CreatePostCategoryDTO(
                $request->validated('name'),
                $request->validated('description'),
            )
        );

        return response($postCategory, 201);
    }

    public function show(string|int $slugOrId)
    {
        $postCategory = $this->service->show($slugOrId);

        return response()->json($postCategory);
    }

    public function getPopular(Request $request)
    {
        $limit = $request->query('limit', 5);
        $categories = $this->service->getPopular($limit);

        return response()->json($categories);
    }

    public function update(UpdatePostCategoryRequest $request, PostCategory $postCategory)
    {
        $payload = $request->only('name', 'description', 'slug');

        $postCategory->update($payload);
        $postCategory->fresh();

        return response()->noContent();
    }

    public function destroy(PostCategory $postCategory)
    {
        $this->authorize('is_admin');

        $postCategory->delete();

        return response()->noContent();
    }
}
