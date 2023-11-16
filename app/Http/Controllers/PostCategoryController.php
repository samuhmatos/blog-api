<?php

namespace App\Http\Controllers;

use App\Adapters\PaginationAdapter;
use App\Models\PostCategory;
use App\Services\PostCategoryService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostCategoryController extends Controller
{
    public function __construct(protected PostCategoryService $postCategoryService)
    {}

    public function index(Request $request){
        // $this->authorize('is_admin');

        $categories = PostCategory::all();

        return response($categories);
    }

    public function paginate(Request $request)
    {
        $page =  $request->query('page', 1);
        $perPage = $request->query('per_page', 10);
        $is_trash = $request->query('is_trash', false);
        $search = $request->query('search', null);


        return response(PaginationAdapter::toJson($this->postCategoryService->paginate(
            page: $page,
            perPage: $perPage,
            isTrash: $is_trash,
            search: $search
        )));
    }

    public function store(Request $request)
    {
        $this->authorize('is_admin');

        $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:post_categories,name'],
            'description' => ['required', 'string', 'max:255']
        ]);

        $payload = $request->only('name', 'description');
        $slug = str()->slug($payload['name']);

        $alreadyExistSlug = PostCategory::where('slug', $slug)->first();

        while($alreadyExistSlug){
            $alreadyExistSlug = PostCategory::where('slug', $slug)->first();
            $slug = $slug . rand(1,20);
        }

        $postCategory = PostCategory::create([
            'name' => $payload['name'],
            'slug' => $slug,
            'description' => $payload['description']
        ]);

        return response($postCategory, 201);

    }

    public function show(string|int $param)
    {
        $postCategory = PostCategory::query()->where('id', $param)->orWhere('slug', $param)->firstOrFail();
        return response($postCategory);
    }

    public function getPopular(Request $request)
    {
        $limit = $request->query('limit', 5);
        $categories = $this->postCategoryService->getPopular($limit);
        return response($categories);
    }

    public function update(Request $request, PostCategory $postCategory)
    {
        $this->authorize('is_admin');


        $request->validate([
            'name' => [
                'string',
                'max:50',
                // $payload['name'] && 'unique:post_categories,name',
                Rule::unique('post_categories')->ignore($postCategory->id)
            ],
            'slug' => [
                'string',
                'max:255',
                //  $payload['slug']  && 'unique:post_categories,slug',
                Rule::unique('post_categories')->ignore($postCategory->id)
            ],
            'description' => ['string', 'max:255']
        ]);

        $payload = $request->only('name', 'description', 'slug');


        $postCategory->update($payload);
        $postCategory->fresh();

        return response($postCategory);
    }

    public function destroy(PostCategory $postCategory)
    {
        $this->authorize('is_admin');

        $postCategory->delete();

        return response()->noContent();
    }
}
