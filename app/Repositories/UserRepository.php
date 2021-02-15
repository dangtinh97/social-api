<?php
namespace App\Repositories;
use App\Models\User;

class UserRepository extends BaseRepository {

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findUserMail($data){
       return $this->model::where('email','=',$data)->orWhere('mail_id','=',$data)->first();
    }


}
