<?php

namespace App\Http\Controllers;


use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(){

    }

    public function store(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'full_name'=>'required',
            'avatar'=>'required',
            'mail_id'=>'required|numeric'
        ]);
       $register =  $this->userService->createUser($request->all());
       return response()->json($register->toArray());
    }

    public function search(Request $request){
       $find =  $this->userService->findUser($request->get('email'));
       return response()->json($find->toArray());
    }

    public function login(Request $request){
        $token = Auth::guard('api')->attempt([
            'mail_id'=>$request->get('mail_id'),
            'password'=>$request->get('mail_id'),
        ]);
        return response()->json([
            'status'=>200,
            'success'=>true,
            'content'=>'Đăng nhập',
            'data'=>['token'=>$token],
        ]);
    }

    //
}
