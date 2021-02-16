<?php


namespace App\Services;


use App\Http\Responses\ResponseCustomize;
use App\Http\Responses\ResponseSuccess;
use App\Models\User;
use App\Repositories\ChatManagerRepository;
use App\Repositories\ChatRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChatService
{

    protected $chatRepository;
    protected $chatManagerRepository;

    public function __construct(ChatRepository $chatRepository, ChatManagerRepository $chatManagerRepository)
    {
        $this->chatRepository = $chatRepository;
        $this->chatManagerRepository = $chatManagerRepository;
    }

    public function create($data)
    {
        $findChatManager = $this->chatManagerRepository->findChat(Auth::id(), (int)$data['user_id_take']);
        if (is_null($findChatManager)) {
            $findChatManager = $this->chatManagerRepository->create([
                'user_id_send' => Auth::id(),
                'user_id_take' => (int)$data['user_id_take'],
                'count' => 0
            ]);
        }
        $findChatManager->increment('count', 1);
        $this->chatRepository->create([
            'user_id_send' => Auth::id(),
            'user_id_take' => (int)$data['user_id_take'],
            'message' => htmlspecialchars($data['message']),
            'type' => $data['type'],
            'attachment_id' => $data['attachment_id'] ?? "",
            'status' => 'NORMAL',
            'chat_manager_id' => $findChatManager->id,
        ]);

        return (new ResponseSuccess());
    }

    public function index($data)
    {
        $findChatManager = $this->chatManagerRepository->findChat(Auth::id(), (int)$data['user_id']);
        if (is_null($findChatManager)) return (new ResponseCustomize(204, 'Không có tin nhắn'));
        $chat = $this->chatRepository->listMessageWithUser($findChatManager->id, $data['last_chat_id']);
        return (new ResponseSuccess($chat));
    }

    public function listUser($data)
    {

        $find = $this->chatManagerRepository->findListChat($data);

        $data = [];
        foreach ($find as $info) {
            if ($info->mail_id === Auth::user()['mail_id']) continue;
            $data[] = [
                'count' => $info->count,
                'mail_id' => $info->mail_id,
                'full_name' => $info->full_name,
                'email' => $info->email,
                'avatar' => $info->avatar,
                'id' => $info->c_id,
            ];
        }

        return (new ResponseSuccess(['list' => $data]));
    }
}
