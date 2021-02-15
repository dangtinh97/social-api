<?php

namespace App\Http\Responses;

class ResponseSuccess extends ApiResponse
{
    public function __construct($response = [], $status = 200, $message = null)
    {
        $this->code = $status;
        $this->success = true;
        $this->message = 'Thành công';
        $this->response = $response;
    }
}
