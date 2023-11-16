<?php

namespace App\DTOs\Newsletter;

class CreateNewsletterDTO
{
    public function __construct(
        public string $email,
    ) {}
}
