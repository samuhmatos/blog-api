<?php

namespace App\Services;

use App\DTOs\ContactDTO;
use App\Models\Contact;
use App\Repositories\ContactRepository;

class ContactService
{
    public function __construct(
        private ContactRepository $repository,
    ){}

    public function store(ContactDTO $contactDTO): Contact
    {
        $createdContact = $this->repository->create([
            'email' => $contactDTO->email,
            'name' => $contactDTO->name,
            'phone' => $contactDTO->phone,
            'subject' => $contactDTO->subject,
            'message' => $contactDTO->message
        ]);

        if(!$createdContact){
            throw new \Exception("Unexpected error ocurred");
        }

        return $createdContact;
    }
}
