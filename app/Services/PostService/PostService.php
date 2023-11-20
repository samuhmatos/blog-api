<?php

namespace App\Services\PostService;

use App\DTOs\Post\CreatePostDTO;
use App\DTOs\Post\PaginatePostDTO;
use App\DTOs\Post\UpdatePostDTO;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class PostService extends PostStorageService{
    public function __construct(
        protected PostRepository $repository
    ){}

    public function paginate(
        PaginatePostDTO $paginatePostDTO
    )
    {
        return $this->repository->paginate(
            page:$paginatePostDTO->page,
            perPage:$paginatePostDTO->perPage,
            search:$paginatePostDTO->search,
            isDraft:$paginatePostDTO->isDraft,
            isTrash:$paginatePostDTO->isTrash,
            categorySlug:$paginatePostDTO->categorySlug
        );
    }

    public function filterByCategory(string $query): Collection
    {
        if($query == "popular"){
            $data = $this->repository->getMostViewed(3);
        }else if($query == "best"){
            $data = $this->repository->getLatestBest(3, false);
        }else{
            $data = $this->repository->getByCategory($query, 3);
        }

        return $data;
    }

    public function getOne(string|int $param): Post
    {
        return $this->repository->getOne($param);
    }

    public function update(UpdatePostDTO $postDTO)
    {
        $payload = [
            'title' => $postDTO->title,
            'slug' => str()->slug($postDTO->title),
            'sub_title' => $postDTO->subTitle,
            'category_id' => $postDTO->categoryId,
            'is_draft' => $postDTO->isDraft,
            'author_id' => auth()->id()
        ];

        if($postDTO->banner){
            Storage::delete($postDTO->imageUrl);

            $image_url = $postDTO->banner
                ->store("/uploads/posts/{$postDTO->postId}/banners/");
            $payload['image_url'] = $image_url;
        }

        $destinyPath = "uploads/posts/{$postDTO->postId}";

        $this->organizeStorage(
            $destinyPath,
            $postDTO->imageContentList,
            true
        );

        $payload['content'] = $this->modifyPostContent(
            $postDTO->content,
            $destinyPath,
            $postDTO->imageContentList
        );

        $update =  $this->repository->update($postDTO->postId, $payload);

        if(!$update){
            throw new \ErrorException("An unexpected error ocurred.");
        }

        return $this->repository->find($postDTO->postId);
    }

    public function store(CreatePostDTO $postDTO)
    {
        $payload = [
            'title'=> $postDTO->title,
            'sub_title' => $postDTO->subTitle,
            'slug' => str()->slug($postDTO->title),
            'category_id' => $postDTO->categoryId,
            'is_draft'=> $postDTO->isDraft,
            'author_id' => auth()->id()
        ];

        $latestPost = $this->repository->latest();
        $lastPostId = $latestPost ? $latestPost->id + 1 : 1;

        $destinyPath = "uploads/posts/{$lastPostId}";

        if($postDTO->banner){
            $image_url = $postDTO->banner->store("{$destinyPath}/banners");
            $payload['image_url'] = $image_url;
        }

        $this->organizeStorage($destinyPath, $postDTO->imageContentList, false);

        $payload['content'] = $this->modifyPostContent(
            $postDTO->content,
            $destinyPath,
            $postDTO->imageContentList
        );

        $post = $this->repository->create($payload);

        if(!$post){
            throw new \ErrorException("An unexpected error ocurred.");
        }

        return $post;
    }


}

?>
