<?php

namespace App\Http\Controllers;


use App\Services\ChatService;
use App\Services\UserService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $chatService;
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function index(Request $request){
        $list = $this->chatService->listUser($request->all());
        return response()->json($list->toArray());
    }

    public function chatWithUser(Request $request){
        $this->validate($request,[
            'user_id'=>'required',
            'last_chat_id'=>'nullable',
        ]);
       $get = $this->chatService->index($request->all());
       return response()->json($get->toArray());
    }

    public function store(Request $request){
        $this->validate($request,[
            'user_id_take'=>'required|exists:users,id',
            'message'=>'required',
            'attachment_id'=>'nullable',
            'type'=>'required'
        ]);
       $send =  $this->chatService->create($request->all());
       return response()->json($send->toArray());
    }

    public function search(Request $request){
//       $find =  $this->chatService->findUser($request->get('email'));
//       return response()->json($find->toArray());
    }

    //
}
