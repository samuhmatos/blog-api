<?php

namespace App\Http\Controllers;

use App\Adapters\PaginationAdapter;
use App\Enums\CategorySlug;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\PostCategory;
use App\Services\PostServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{

    public function __construct(
        protected PostServices $postServices
    ){}


    public function index(Request $request)
    {
        $query = $request->query('category');

        if($query == "popular"){
            $data =  $this->postServices->getPopular();
        }else if($query == "best"){
            $data = $this->postServices->getLatestBest();
        }else{
            $data = $this->postServices->getByCategory($query);
        }

        // $args = [
        //     'popular' => $this->postServices->getPopular(),
        //     'best'=> $this->postServices->getLatestBest(),
        //     'videos'=> $this->postServices->getByCategory(CategorySlug::videos),
        //     'reviews'=> $this->postServices->getByCategory(CategorySlug::reviews),
        //     'technology'=> $this->postServices->getByCategory(CategorySlug::tech)
        // ];

        // if(array_key_exists($query, $args))
        //     return response($args[$query]);
        // else
        //     throw new NotFoundHttpException("Not Found category");

        if($data)
            return response($data);
        else
            throw new NotFoundHttpException("Not Found category");
    }

    public function feed(Request $request)
    {
        $page =  $request->query('page', 1);
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');

        return response(PaginationAdapter::toJson($this->postServices->paginateFeed(page:$page, perPage: $perPage, search: $search)));
    }

    public function suggestion()
    {
        $posts = $this->postServices->getPopular(15);

        return response($posts->random(2));
    }

    public function storeView(Post $post)
    {
        //$views = $post->views + 1;
        $post->views += 1;
        $post->save();

        return response(['views'=> $post->views], 201);
    }


    public function store(PostRequest $request)
    {
        $request->validate(['title'=> 'unique:posts']);
        $this->authorize('is_admin');

        $payload = $request->only(['title', 'sub_title', 'content', 'category_id']);
        $banner = $request->file('banner');
        $image_url = $banner->store('/uploads/posts/banners/');

        $payload['slug'] = str()->slug($payload['title']);
        $payload['author_id'] = auth()->user()->id;
        $payload['image_url'] = $image_url;

        $post = Post::create($payload);


        return response($post, 201);
    }

    public function show(string $slug)
    {
        $post = $this->postServices->getPostBySlug($slug);
        return response($post);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('is_admin');

        $payload = $request->only(['title', 'sub_title', 'content', 'category_id']);
        $banner = $request->file('banner');

        $payload['slug'] = str()->slug($payload['title']);
        $payload['author_id'] = auth()->user()->id;

        if($banner){
            Storage::delete($post->image_url);

            $image_url = $banner->store('/uploads/posts/banners/');
            $payload['image_url'] = $image_url;
        }


        $post->update($payload);

        return response($post);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('is_admin');

        $post->delete();

        return response()->noContent();

    }
}
