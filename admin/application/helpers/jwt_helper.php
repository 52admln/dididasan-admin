<?php

/**
 * Created by PhpStorm.
 * User: Wyj
 * Date: 17/4/27
 * Time: 下午2:06
 */
class jwt_helper extends CI_Controller
{
    const CONSUMER_KEY = 'dididasan';
    const CONSUMER_SECRET = 'dididasan';
    const CONSUMER_TTL = 86400;

    public static function create($userid)
    {
        $CI =& get_instance();
        $CI->load->library('JWT');
        $token = $CI->jwt->encode(array(
            'consumerKey' => self::CONSUMER_KEY,
            'userId' => $userid,
            'issuedAt' => date(DATE_ISO8601, strtotime("now")),
            'ttl' => self::CONSUMER_TTL
        ), self::CONSUMER_SECRET);
        return $token;
    }

    public static function validate($header)
    {
        $CI =& get_instance();
        $CI->load->library('JWT');
        list($token) = sscanf($header, 'token %s');
        try {
            $CI->jwt->decode($token, self::CONSUMER_SECRET);
            return true;
        } catch(Exception $e) {
            return false;
        }

    }

    public static function decode()
    {
        $CI =& get_instance();
        $CI->load->library('JWT');
        list($token) = sscanf($header, 'token %s');
        try {
            $decodeToken = $CI->jwt->decode($token, self::CONSUMER_SECRET);
            return $decodeToken;
        } catch(Exception $e) {
            return false;
        }
    }
}