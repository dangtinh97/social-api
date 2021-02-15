<?php


namespace App\Repositories;


use App\Models\Chat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ChatRepository extends BaseRepository
{
    public function __construct(Chat $model)
    {
        $this->model = $model;
    }

    public function listMessageWithUser($chatId,$data){
        $query  =$this->model::query();
        $query->where('chat_manager_id',$chatId);
        if(!empty($data)) $query->where('id','<',$data);
        $query->orderByDesc('id');
        $query->take(10);
        return $query->get();
    }
}
