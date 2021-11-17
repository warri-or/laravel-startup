<?php

namespace App\Http\Modules\Sog;

class SogChatService
{
    public function __construct(SogChatRepository $repository)
    {
        $this->repo = $repository;
    }

    public function dd(){

    }
}
