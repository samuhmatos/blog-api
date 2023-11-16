<?php

namespace App\DTOs\Newsletter;

use App\Models\Newsletter;

class DestroyNewsletterDTO
{
    public function __construct(
        public Newsletter $newsletter,
        public string|null $token
    ) {}
}
