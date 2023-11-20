<?php
//TODO: CRIAR NOVA COLUNA NO BANCO DE DADOS PARA PODER guardar todas as imagens que estao sendo usadas no conteudo da postagem. E se remover ou editar, o sistema deve fazer essa filtragem, atualizar o banco de dados e remover/editar o que for necessário no storage. Suesttão: guardar em uma array/objeto

namespace App\Http\Controllers;

use App\Adapters\PaginationAdapter;
use App\DTOs\Post\CreatePostDTO;
use App\DTOs\Post\PaginatePostDTO;
use App\DTOs\Post\UpdatePostDTO;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostService\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function __construct(
        protected PostService $service,
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
        $categorySlug = $request->query('category');


        return response(
            PaginationAdapter::toJson(
                $this->service->paginate(
                    new PaginatePostDTO(
                        page:$page,
                        perPage: $perPage,
                        search: $search,
                        isDraft: $isDraft,
                        isTrash: $isTrash,
                        categorySlug: $categorySlug,
                    )
                )
            )
        );
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

    public function index(Request $request)
    {
        $query = $request->query('category');

        if(!$query)
            throw new NotFoundHttpException("Not Found category");


        $data = $this->service->filterByCategory($query);

        if($data)
            return response($data);
        else
            throw new NotFoundHttpException("Not Found category");
    }

    public function storeView(Post $post)
    {
        $post->views += 1;
        $post->save();

        return response(['views'=> $post->views], 201);
    }


    public function store(CreatePostRequest $request)
    {
        $imageContentList = $this->getImageContentList($request->input('img_content_list'));

        $post = $this->service->store(
            new CreatePostDTO(
                title: $request->title,
                subTitle: $request->sub_title,
                content: $request->content,
                categoryId: $request->category_id,
                isDraft: $request->is_draft,
                banner: $request->file('banner'),
                imageContentList: $imageContentList
            )
        );

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
        $post = $this->service->getOne($param);
        return response($post);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $imageContentList = $this->getImageContentList($request->input('img_content_list'));

        $updatedPost  = $this->service->update(
            new UpdatePostDTO(
                postId: $post->id,
                title: $request->title,
                subTitle: $request->sub_title,
                content: $request->content,
                categoryId: $request->category_id,
                isDraft: $request->is_draft,
                banner: $request->file('banner'),
                imageUrl: $post->image_url,
                imageContentList: $imageContentList
            )
        );

        return response($updatedPost);
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

    private function getImageContentList($list):Array
    {
        if(is_null($list) || !$list){
            return [];
        }

        $imageContentList = $list;

        if(!is_array($imageContentList)){
            try{
                $imageContentList = json_decode($imageContentList);
            }catch(\Exception $e){
                throw new UnsupportedMediaTypeHttpException('O campo img_content_list precisa ser uma array');
            }
        }

        return $imageContentList;
    }
}

//TODO: INBOX CHAT
