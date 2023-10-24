<?php
//TODO: CRIAR NOVA COLUNA NO BANCO DE DADOS PARA PODER guardar todas as imagens que estao sendo usadas no conteudo da postagem. E se remover ou editar, o sistema deve fazer essa filtragem, atualizar o banco de dados e remover/editar o que for necessário no storage. Suesttão: guardar em uma array/objeto

namespace App\Http\Controllers;

use App\Adapters\PaginationAdapter;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{

    public function __construct(
        protected PostServices $postServices
    ){}

    private function paginate(
        Request $request,
        bool $isDraft,
        bool $isTrash,
    )
    {
        $page =  $request->query('page', 1);
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');
        $categorySlug = $request->query('category', null);


        return response(
            PaginationAdapter::toJson(
                $this->postServices->paginate(
                    page:$page,
                    perPage: $perPage,
                    search: $search,
                    isDraft: $isDraft,
                    isTrash: $isTrash,
                    categorySlug: $categorySlug,
                )
            )
        );
    }

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

        if($data)
            return response($data);
        else
            throw new NotFoundHttpException("Not Found category");
    }

    public function paginateFeed(Request $request)
    {
        return $this->paginate($request, false, false);
    }

    public function paginateDrafts(Request $request)
    {
        $this->authorize('is_admin');

        return $this->paginate($request, true, false);
    }

    public function paginateTrash(Request $request)
    {
        $this->authorize('is_admin');

        return $this->paginate($request, false, true);
    }

    public function suggestion()
    {
        $posts = $this->postServices->getPopular(15);

        return response($posts->random(2));
    }

    public function storeView(Post $post)
    {
        $post->views += 1;
        $post->save();

        return response(['views'=> $post->views], 201);
    }


    public function store(PostRequest $request)
    {
        $this->authorize('is_admin');
        $request->validate(['title'=> 'unique:posts']);

        $payload = $request->only(['title', 'sub_title', 'content', 'category_id', 'is_draft']);
        $banner = $request->file('banner');

        if($banner){
            $image_url = $banner->store('/uploads/posts/banners');
            $payload['image_url'] = $image_url;
        }

        $payload['slug'] = str()->slug($payload['title']);
        $payload['author_id'] = auth()->user()->id;

        $post = Post::create($payload);


        return response($post, 201);
    }

    public function uploadSourceContent(Request $request)
    {
        $this->authorize('is_admin');
        $request->validate([
            'file' => ['required', 'image', 'max:500000']
        ]);

        $file = $request->file('file');
        $fileStored = $file->store('/uploads/posts/contents');
        $file = Storage::url($fileStored);

        return response([
            'url' => $file
        ]);

    }

    public function show(string $param)
    {
        $post = $this->postServices->getOne($param);
        return response($post);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('is_admin');

        $payload = $request->only(['title', 'sub_title', 'content', 'category_id', 'is_draft']);
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

    public function restore(Request $request, int $post_id)
    {
        $post = Post::withTrashed()->findOrFail($post_id);
        $post->restore();
        return response($post);
    }
}

//TODO: INBOX CHAT
