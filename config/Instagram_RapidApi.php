<?php

namespace Config;
use Exception as Exception;
class Instagram_RapidApi
{
    public static function userDetail($username)
    {
        try {
            $curl = curl_init();

            $url = "https://instagram230.p.rapidapi.com/user/details?username=".$username;

            $headers = [
                'x-rapidapi-host: instagram230.p.rapidapi.com',
                'x-rapidapi-key: '
            ];


            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            /*if (curl_errno($curl)) {
                throw new Exception(curl_errno($curl));
            }*/

            curl_close($curl);

            if ($err) {
                throw new Exception($err);
            } else {
                return json_decode($response, true);
            }
        } catch (\Exception $ex) {
            throw new Exception("Ocorreu em userDetail: " . $ex->getMessage(), 1);
        }
    }

    public static function userPosts($username,$cursor = "")
    {
        try {
            $curl = curl_init();

            if(!empty($cursor)) $cursor = "&cursor=".$cursor;

            $url = "https://instagram230.p.rapidapi.com/user/posts?username=".$username.$cursor;

            $headers = [
                'x-rapidapi-host: instagram230.p.rapidapi.com',
                'x-rapidapi-key: '
            ];


            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            /*if (curl_errno($curl)) {
                throw new Exception(curl_errno($curl));
            }*/

            curl_close($curl);

            if ($err) {
                throw new Exception($err);
            } else {
                return json_decode($response, true);
            }
        } catch (\Exception $ex) {
            throw new Exception("Ocorreu em userDetail: " . $ex->getMessage(), 1);
        }
    }
}