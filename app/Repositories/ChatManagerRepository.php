<?php


namespace App\Repositories;


use App\Http\Responses\ResponseSuccess;
use App\Models\ChatManager;
use Illuminate\Support\Facades\Auth;

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

    public function findListChat($data){
        $query = $this->model::query();

        $query->where(function ($q){
            $q->where('user_id_send',Auth::id())->orWhere('user_id_take',Auth::id());
        });
        if(!empty($data['last_chat_id'])) $query->where('chat_managers.id','<',(int)$data['last_chat_id']);
        $query->orderByDesc('chat_managers.updated_at');
        $query->select(['chat_managers.id as c_id','chat_managers.user_id_send','chat_managers.user_id_take','users.full_name','count','users.mail_id']);
        $query->take(20);
        $query->join('users',function($join){
            $join->on('users.id','=','chat_managers.user_id_send');
                $join->orOn('users.id','=','chat_managers.user_id_take');
        });
        return $query->get();
    }
}
