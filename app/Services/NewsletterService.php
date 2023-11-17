<?php

namespace App\Services;

use App\DTOs\Newsletter\CreateNewsletterDTO;
use App\DTOs\Newsletter\DestroyNewsletterDTO;
use App\Repositories\NewsletterRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsletterService
{
    public function __construct(
        private NewsletterRepository $repository
    ){}

    public function subscribe(CreateNewsletterDTO $newsletterDTO): void
    {
        $newsletter = $this->repository->updateOrCreate(
            ['email' => $newsletterDTO->email],
            ['token' => Hash::make(Str::random(60))]
        );

        if(!$newsletter) {
            throw new \ErrorException('Unexpected error ocurred.');
        }

        return;
    }

    public function unsubscribe(DestroyNewsletterDTO $newsletterDTO): void
    {
        if(
            !$newsletterDTO->token ||
            $newsletterDTO->newsletter->token != $newsletterDTO->token
        ) {
            throw new NotFoundHttpException("Token not found");
        }

        $deletedNewsletter = $this->repository->delete($newsletterDTO->newsletter->id);

        if(! $deletedNewsletter) {
            throw new \ErrorException('Unexpected error ocurred.', 500);
        }


        return;
    }
}
