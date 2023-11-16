<?php

namespace App\DTOs;

class ContactDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
        public string $subject,
        public string $message,
    ){}
}
