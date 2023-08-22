<?php

    namespace App\Repositories;

    use App\Models\Post;
    use App\Repositories\Contracts\PaginationInterface;
use Illuminate\Support\Facades\DB;

    class PostRepository{
        public function __construct(protected Post $post){

        }

        public function paginateRecent(int $page = 1, int $perPage = 15, string $filter = null): PaginationInterface
        {
            $result = Post::with(['category', 'author'])
                ->withReactionCounts()
                ->where(function ($query) use ($filter) {
                    if ($filter) {
                        $query->where('title', 'like', "%{$filter}%");
                        $query->orWhere('sub_title', 'like', "%{$filter}%");
                    }
                })
                ->paginate($perPage, ['*'], 'page', $page);

            return new PaginationPresenter($result);
        }

        /**
         * Get the "Popular" Posts
         */
        public function getMostViewed()
        {
            return Post::with(['category', 'author'])
                ->withReactionCounts()
                ->orderBy('views','desc')
                ->take(3)
                ->get();
        }

        public function getTrendVideos(){
            $trendVideos =  Post::with(['category', 'author'])
                ->withReactionCounts()
                ->join('post_categories', 'post_categories.id', '=', 'posts.category_id')
                ->where('post_categories.slug', 'videos')
                ->orderByDesc('views')
                ->take(3)
                ->get();

            return $trendVideos;

        }

        public function getLatestReviews(){
            return Post::with(['category', 'author'])
                ->withReactionCounts()
                ->join('post_categories', 'post_categories.id', '=', 'posts.category_id')
                ->where('post_categories.slug', 'reviews')
                ->orderBy('views','desc')
                ->take(3)
                ->get();
        }

        public function getLatestBest(){
            return Post::with(['category', 'author'])
                ->withReactionCounts()
                ->orderByDesc('like_count')
                ->orderBy('views', 'desc')
                ->limit(3)
                ->get();
        }

        public function getBestTechnology() {
            return Post::with(['category', 'author'])
                ->withReactionCounts()
                ->join('post_categories', 'post_categories.id', '=', 'posts.category_id')
                ->where('post_categories.slug', 'tech')
                ->orderBy('views','desc')
                ->take(3)
                ->get();
        }

        public function getPostBySlug(string $slug){
            return Post::with(['author', 'comments.user', "category"])
                ->withReactionCounts()
                ->where('slug',$slug)
                ->firstOrFail();

        }
    }
