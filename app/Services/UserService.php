<?php


namespace App\Services;


use App\Http\Responses\ResponseSuccess;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function createUser($data){
        $findUser= $this->userRepository->findFirst('email',$data['email']);
        if(!is_null($findUser)){
            $login = Auth::guard('api')->attempt([
                'email'=>$data['email'],
                'password'=>$data['mail_id']
            ]);
            return (new ResponseSuccess([
                'token'=>$login,
            ]));
        }
        $data['password'] = Hash::make($data['mail_id']);
        $this->userRepository->create($data);
        $login = Auth::guard('api')->attempt([
            'email'=>$data['email'],
            'password'=>$data['mail_id']
        ]);
        return (new ResponseSuccess([
            'token'=>$login,
        ]));
    }

    public function findUser($email){
       $find =  $this->userRepository->findUserMail($email);
        if(is_null($email) || is_null($find)) return (new ResponseSuccess());
        return (new ResponseSuccess([
            'full_name'=>$find->full_name,
            'email'=>$find->email,
            'mail_id'=>$find->mail_id,
            'avatar'=>$find->avatar,
            'id'=>$find->id,
        ]));
    }
}
