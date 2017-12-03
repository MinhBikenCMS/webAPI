<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse extends JsonResponse
{
    private static $array = array(
        1000 => array('type' => 'success', 'msg' => 'Success'),
        1001 => array('type' => 'error', 'msg' => 'Error'),
        1002 => array('type' => 'error', 'msg' => 'Request timeout'),
        1004 => array('type' => 'error', 'msg' => 'Not found'),

        // USER
        1100 => array('type' => 'error', 'msg' => 'Account does not exist', 'http_code' => 401),
        1101 => array('type' => 'error', 'msg' => 'Account is disabled', 'http_code' => 403),
        1102 => array('type' => 'error', 'msg' => 'Account is locked', 'http_code' => 403),
        1103 => array('type' => 'error', 'msg' => 'Invalid credentials', 'http_code' => 401),
        1104 => array('type' => 'error', 'msg' => 'Invalid access token', 'http_code' => 403),
        1105 => array('type' => 'error', 'msg' => 'Access token required', 'http_code' => 401),
        1106 => array('type' => 'error', 'msg' => 'You have requested to reset password recently'),
        1107 => array('type' => 'error', 'msg' => 'Confirmation code not found'),
        1108 => array('type' => 'error', 'msg' => 'Current Password is incorrect'),
        1109 => array('type' => 'error', 'msg' => 'You don\'t have valid role to use this application'),
    );


    public function __construct($code, $data = NULL, $msg = NULL)
    {
        $status = isset(self::$array[$code]['http_code']) ? self::$array[$code]['http_code'] : 200;
        parent::__construct($data, $status);

        $message = array(
            'message' => array(
                'type' => self::$array[$code]['type'],
                'code' => $code,
                'msg' => $msg ? $msg : self::$array[$code]['msg']
            )
        );
        
        if ($data)
            $message['data'] = $data;

        $this->setData($message);
    }
}