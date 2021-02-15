<?php


namespace App\Repositories;


use App\Http\Responses\ResponseSuccess;
use App\Models\ChatManager;

class ChatManagerRepository extends BaseRepository
{
    public function __construct(ChatManager $model)
    {
        $this->model = $model;
    }

    public function findChat($userOne, $userTwo)
    {
        $find = $this->model::whereIn('user_id_send', [$userTwo, $userOne])->whereIn('user_id_take', [$userTwo, $userOne])->first();
        return $find;
    }
}
