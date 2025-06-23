<?php

namespace Config;

use Exception as Exception;

class OpenAI
{
    public static function completions($prompt,$entrada)
    {
        try {
            $curl = curl_init();

            $url = "https://api.openai.com/v1/chat/completions";

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $GLOBALS['OPENAI']
            ];

            $data['model'] = "gpt-4o";
            $data['messages'][0]['role'] = "assistant";
            $data['messages'][0]['content'] = $prompt;
            $data['messages'][1]['role'] = "user";
            $data['messages'][1]['content'] = $entrada;

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => json_encode($data)
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                throw new Exception($err);
            } else {
                $saida =  json_decode($response, true);
                if(isset($saida['choices']) && isset($saida['choices'][0]['message']['content']) && !empty($saida['choices'][0]['message']['content']))return $saida['choices'][0]['message']['content'];
                else if(isset($saida['error'])){
                    throw new Exception($saida['error']);
                }
                else{
                    throw new Exception("Saida LLM Vazia OpenAi");
                }
            }
        } catch (\Exception $ex) {
            throw new Exception("Ocorreu em completion OpenAi: " . $ex->getMessage(), 1);
        }
    }
    public static function createThread()
    {
        try {
            $curl = curl_init();

            $url = "https://api.openai.com/v1/threads";

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $GLOBALS['OPENAI'],
                'OpenAI-Beta: assistants=v2',
                ''
            ];

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POST => true,
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
            throw new Exception("Ocorreu em addMessagesToThread: " . $ex->getMessage(), 1);
        }
    }
    public static function addMessagesToThread($messagem,$threadid)
    {
        try {
            $curl = curl_init();

            $url = "https://api.openai.com/v1/threads/".$threadid."/messages";

            $data = [
                'role' => 'user',
                'content' => $messagem
            ];

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $GLOBALS['OPENAI'],
                'OpenAI-Beta: assistants=v2'
            ];

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
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
            throw new Exception("Ocorreu em addMessagesToThread: " . $ex->getMessage(), 1);
        }
    }

    public static function createRun($threadid,$assistandid)
    {
        try {
            $curl = curl_init();

            $url = "https://api.openai.com/v1/threads/".$threadid."/runs";

            $data = [
                'assistant_id' => $assistandid,
                'instructions' => 'retorne somente o json'
            ];

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $GLOBALS['OPENAI'],
                'OpenAI-Beta: assistants=v2'
            ];

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
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
            throw new Exception("Ocorreu em addMessagesToThread: " . $ex->getMessage(), 1);
        }
    }

    public static function listMessages($threadid)
    {
        try {
            $curl = curl_init();

            $url = "https://api.openai.com/v1/threads/".$threadid."/messages";


            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $GLOBALS['OPENAI'],
                'OpenAI-Beta: assistants=v2'
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
            throw new Exception("Ocorreu em addMessagesToThread: " . $ex->getMessage(), 1);
        }
    }

    public static function createThreadAndRun($message,$assistantid)
    {
        try {
            $curl = curl_init();

            $url = "https://api.openai.com/v1/threads/runs";

            $data = [
                'assistant_id' => $assistantid,
                'thread' => [
                    'messages' => [[
                        'role' => 'user',
                        'content' => $message
                    ]]
                ]
            ];

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $GLOBALS['OPENAI'],
                'OpenAI-Beta: assistants=v2'
            ];

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
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
            throw new Exception("Ocorreu em addMessagesToThread: " . $ex->getMessage(), 1);
        }
    }

    public static function retrieveRun($runid, $threadid)    {
        try {
            $curl = curl_init();

            $url = "https://api.openai.com/v1/threads/".$threadid."/runs/".$runid;

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $GLOBALS['OPENAI'],
                'OpenAI-Beta: assistants=v2'
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

            sleep(1);

            if ($err) {
                throw new Exception($err);
            } else {
                return json_decode($response, true);
            }
        } catch (\Exception $ex) {
            throw new Exception("Ocorreu em addMessagesToThread: " . $ex->getMessage(), 1);
        }
    }

    public static function deleteThread( $threadid)    {
        try {
            $curl = curl_init();

            $url = "https://api.openai.com/v1/threads/".$threadid;

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $GLOBALS['OPENAI'],
                'OpenAI-Beta: assistants=v2'
            ];

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_CUSTOMREQUEST => 'DELETE'
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            /*if (curl_errno($curl)) {
                throw new Exception(curl_errno($curl));
            }*/

            curl_close($curl);

            sleep(1);

            if ($err) {
                throw new Exception($err);
            } else {
                return json_decode($response, true);
            }
        } catch (\Exception $ex) {
            throw new Exception("Ocorreu em addMessagesToThread: " . $ex->getMessage(), 1);
        }
    }
}