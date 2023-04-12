<?php

namespace App\Helpers;

class AppHelper {

    public function responseMessageHandle($code, $message) {

        $data['code'] = $code;
        $data['data'] = ['msg' => $message];

        return (($data));
    }

    public function responseEntityHandle($code, $msg, $response) {

        $data['code'] = $code;
        $data['msg'] = $msg;
        $data['data'] = [$response];

        return $data;
    }
}

?>