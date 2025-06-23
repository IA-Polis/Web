<?php

namespace Config;

use Exception as Exception;

class Waha
{
    public static function check_connection_session(){
        try {
            $curl = curl_init();


            curl_setopt_array($curl, [
                CURLOPT_URL => "https://whatsapp.isaias.eti.br/api/sessions/".$GLOBALS['Waha_session'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 100,
                CURLOPT_TIMEOUT => 2000,
                CURLOPT_HTTPHEADER => ['X-Api-Key: '.$GLOBALS['Waha_token']],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            if (curl_errno($curl)) {
                throw new Exception(curl_errno($curl));
            }

            //print_r($response);

            curl_close($curl);

            if ($err) {
                throw new Exception($err);
            } else {
                return json_decode($response, true);
            }
        } catch (Exception $ex) {
            throw new Exception("Ocorreu em screenshot: " . $ex->getMessage(), 1);
        }
    }

    public static function send_message($message,$to,$sleep = 10){
        try {
            $curl = curl_init();

            Waha::simulateTyping($to);

            $data['chatId'] = $to;
            $data['session'] = $GLOBALS['Waha_session'];
            $data['text'] = $message;
            $data['linkPreview'] = true;

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://whatsapp.isaias.eti.br/api/sendText",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 100,
                CURLOPT_TIMEOUT => 2000,
                CURLOPT_HTTPHEADER => array(
                    "X-Api-Key: ".$GLOBALS['Waha_token'],
                    "Content-Type: application/json"
                ),
                CURLOPT_POSTFIELDS => json_encode($data)
            ]);
            $response = curl_exec($curl);

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);

            curl_close($curl);

            sleep($sleep);

            if ($err) {
                throw new Exception($err);
            } else {
                return json_decode($response, true);
            }
        } catch (Exception $ex) {
            throw new Exception("Ocorreu em screenshot: " . $ex->getMessage(), 1);
        }
    }

    public static function send_image($message,$url, $to)
    {
        try {
            $curl = curl_init();

            $type = pathinfo($url, PATHINFO_EXTENSION);
            $filename = pathinfo($url, PATHINFO_FILENAME);


            $data['chatId'] = $to;
            $data['session'] = $GLOBALS['Waha_session'];
            $data['file']['mimetype'] = "image/".$type;
            $data['file']['filename'] = $filename;
            $data['file']['url'] = $url;
            $data['caption'] = $message;


            curl_setopt_array($curl, [
                CURLOPT_URL => "https://whatsapp.isaias.eti.br/api/sendImage",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 100,
                CURLOPT_TIMEOUT => 2000,
                CURLOPT_HTTPHEADER => array(
                    "X-Api-Key: ".$GLOBALS['Waha_token'],
                    "Content-Type: application/json"
                ),
                CURLOPT_POSTFIELDS => json_encode($data)
            ]);
            $response = curl_exec($curl);

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);

            curl_close($curl);

            sleep(10);

            if ($err) {
                throw new Exception($err);
            } else {
                return json_decode($response, true);
            }
        } catch (Exception $ex) {
            throw new Exception("Ocorreu em screenshot: " . $ex->getMessage(), 1);
        }
    }

    public static function send_link_preview($message,$url, $to)
    {
        Waha::send_message($message."\n".$url,$to);

        /*
        try {
            $curl = curl_init();

            $data['chatId'] = $to;
            $data['session'] = $GLOBALS['Waha_session'];
            $data['url'] = $url;
            $data['title'] = $message;


            curl_setopt_array($curl, [
                CURLOPT_URL => "https://whatsapp.isaias.eti.br/api/sendLinkPreview",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 100,
                CURLOPT_TIMEOUT => 2000,
                CURLOPT_HTTPHEADER => array(
                    "X-Api-Key: ".$GLOBALS['Waha_token'],
                    "Content-Type: application/json"
                ),
                CURLOPT_POSTFIELDS => json_encode($data)
            ]);

            $response = curl_exec($curl);

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);

            curl_close($curl);

            sleep(10);

            if ($err) {
                throw new Exception($err);
            } else {
                return json_decode($response, true);
            }
        } catch (Exception $ex) {
            throw new Exception("Ocorreu em screenshot: " . $ex->getMessage(), 1);
        }*/
    }

    public static function send_video($message,$url, $to)
    {
        try {
            $curl = curl_init();

            $type = pathinfo($url, PATHINFO_EXTENSION);
            $filename = pathinfo($url, PATHINFO_FILENAME);


            $data['chatId'] = $to;
            $data['session'] = $GLOBALS['Waha_session'];
            $data['file']['mimetype'] = "video/".$type;
            $data['file']['filename'] = $filename;
            $data['file']['url'] = $url;
            $data['caption'] = $message;


            curl_setopt_array($curl, [
                CURLOPT_URL => "https://whatsapp.isaias.eti.br/api/sendVideo",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 100,
                CURLOPT_TIMEOUT => 2000,
                CURLOPT_HTTPHEADER => array(
                    "X-Api-Key: ".$GLOBALS['Waha_token'],
                    "Content-Type: application/json"
                ),
                CURLOPT_POSTFIELDS => json_encode($data)
            ]);

            $response = curl_exec($curl);

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);

            curl_close($curl);

            sleep(10);

            if ($err) {
                throw new Exception($err);
            } else {
                return json_decode($response, true);
            }
        } catch (Exception $ex) {
            throw new Exception("Ocorreu em screenshot: " . $ex->getMessage(), 1);
        }
    }


    public static function messages($to)
    {
        ///api/{session}/messages-admins-only
        try {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://whatsapp.isaias.eti.br/api/".$GLOBALS['Waha_session']."/chats/".$to."/messages?downloadMedia=true&limit=3000",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 100,
                CURLOPT_TIMEOUT => 2000,
                CURLOPT_HTTPHEADER => array(
                    "X-Api-Key: ".$GLOBALS['Waha_token']
                )
            ]);

            $response = curl_exec($curl);

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);

            curl_close($curl);


            if ($err) {
                throw new Exception($err);
            } else {
                return json_decode($response, true);
            }
        } catch (Exception $ex) {
            throw new Exception("Ocorreu em screenshot: " . $ex->getMessage(), 1);
        }
    }

    public static function clear_chat($to,$isGroup = true)
    {

    }

    public static function remove_participant_group($groupID,$phone)
    {
        ///api/{session}/messages-admins-only
        try {
            $curl = curl_init();

            $data['participants'][0]['id'] = $phone;

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://whatsapp.isaias.eti.br/api/".$GLOBALS['Waha_session']."/groups/".urlencode($groupID)."/participants/remove",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 100,
                CURLOPT_TIMEOUT => 2000,
                CURLOPT_HTTPHEADER => array(
                    "X-Api-Key: ".$GLOBALS['Waha_token'],
                    "Content-Type: application/json"
                ),
                CURLOPT_POSTFIELDS => json_encode($data)
            ]);

            $response = curl_exec($curl);

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);

            curl_close($curl);


            if ($err) {
                throw new Exception($err);
            } else {
                return json_decode($response, true);
            }
        } catch (Exception $ex) {
            throw new Exception("Ocorreu em remove_participant_group: " . $ex->getMessage(), 1);
        }
    }

    public static function simulateTyping($to){
        try {
            $curl = curl_init();


            $data['session'] = $GLOBALS['Waha_session'];
            $data['chatId'] = $to;

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://whatsapp.isaias.eti.br/api/startTyping",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 100,
                CURLOPT_TIMEOUT => 2000,
                CURLOPT_HTTPHEADER => array(
                    "X-Api-Key: ".$GLOBALS['Waha_token'],
                    "Content-Type: application/json"
                ),
                CURLOPT_POSTFIELDS => json_encode($data)
            ]);

            $response = curl_exec($curl);

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);

            curl_close($curl);


            $curl = curl_init();

            sleep(rand(1,10));

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://whatsapp.isaias.eti.br/api/stopTyping",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 100,
                CURLOPT_TIMEOUT => 2000,
                CURLOPT_HTTPHEADER => array(
                    "X-Api-Key: ".$GLOBALS['Waha_token'],
                    "Content-Type: application/json"
                ),
                CURLOPT_POSTFIELDS => json_encode($data)
            ]);

            $response = curl_exec($curl);

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);

            curl_close($curl);

        } catch (Exception $ex) {
            throw new Exception("Ocorreu em remove_participant_group: " . $ex->getMessage(), 1);
        }
    }

    public static function check_contact_exists($telefone)
    {
        ///api/{session}/messages-admins-only
        try {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://whatsapp.isaias.eti.br/api/contacts/check-exists?session=".$GLOBALS['Waha_session']."&phone=".$telefone,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 100,
                CURLOPT_TIMEOUT => 2000,
                CURLOPT_HTTPHEADER => array(
                    "X-Api-Key: ".$GLOBALS['Waha_token']
                )
            ]);

            $response = curl_exec($curl);

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);

            curl_close($curl);


            if ($err) {
                throw new Exception($err);
            } else {
                return json_decode($response, true);
            }
        } catch (Exception $ex) {
            throw new Exception("Ocorreu em screenshot: " . $ex->getMessage(), 1);
        }
    }

    public static function send_seen($chatid)
    {
        ///api/{session}/messages-admins-only
        try {
            $curl = curl_init();


            $data['session'] = $GLOBALS['Waha_session'];
            $data['chatId'] = $chatid;
            $data['participant'] = null;

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://whatsapp.isaias.eti.br/api/".$GLOBALS['Waha_session']."/groups/".$chatid."/participants/remove",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 100,
                CURLOPT_TIMEOUT => 2000,
                CURLOPT_HTTPHEADER => array(
                    "X-Api-Key: ".$GLOBALS['Waha_token'],
                    "Content-Type: application/json"
                ),
                CURLOPT_POSTFIELDS => json_encode($data)
            ]);

            $response = curl_exec($curl);

            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);

            curl_close($curl);


            if ($err) {
                throw new Exception($err);
            } else {
                return json_decode($response, true);
            }
        } catch (Exception $ex) {
            throw new Exception("Ocorreu em remove_participant_group: " . $ex->getMessage(), 1);
        }
    }
}