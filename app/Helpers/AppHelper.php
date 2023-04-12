<?php

namespace App\Helpers;

class AppHelper {

    public function responseMessageHandle($code, $message) {

        $data['code'] = $code;
        $data['data'] = ['msg' => $message];

        return (($data));
    }

    public function responseEntityHandle($code, $msg, $response, $token = null) {

        $data['code'] = $code;
        $data['msg'] = $msg;
        $data['data'] = [$response];
        
        if ($token != null) {
            $data['token'] = $token;
        }

        return $data;
    }
}

?>