<?php

namespace App\Http\Repositories\Api\Auth;
use App\Http\Repositories\BaseRepository;
use App\Models\User;

class AuthRepository extends BaseRepository
{
    /**
       * Instantiate repository
       *
       * @param Api/Auth/Auth $model
       */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    // Your methods for repository
}
