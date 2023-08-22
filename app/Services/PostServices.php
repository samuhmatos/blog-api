<?php

    namespace App\Services;

use App\Repositories\PostRepository;

    class PostServices{
        public function __construct(protected PostRepository $postRepository){}

        public function paginateRecent(int $page = 1, int $perPage = 15, string|null $search = null){
            return $this->postRepository->paginateRecent(page:$page, perPage: $perPage, filter: $search);
        }

        /**
         * Get the "Popular" Posts
         */
        public function getPopular()
        {
            return $this->postRepository->getMostViewed();
        }

        public function getTrendVideos(){
            return $this->postRepository->getTrendVideos();
        }

        public function getLatestReviews(){
            return $this->postRepository->getLatestReviews();
        }

        public function getLatestBest(){
            return $this->postRepository->getLatestBest();
        }

        public function getBestTechnology(){
            return $this->postRepository->getBestTechnology();
        }

        public function getPostBySlug(string $slug)
        {
            return $this->postRepository->getPostBySlug($slug);
        }
    }

?>
