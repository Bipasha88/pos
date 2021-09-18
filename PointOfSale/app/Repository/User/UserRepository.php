<?php

namespace App\Repository\User;

use App\Models\User;
use App\Repository\Base\BaseRepository;

class UserRepository extends BaseRepository implements IUserRepository {

    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
