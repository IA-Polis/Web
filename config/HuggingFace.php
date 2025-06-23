<?php

namespace Config;
use Exception as Exception;
class HuggingFace
{
    public static function completion($arrayCompletion)
    {
        try {
            $curl = curl_init();

            $url = "https://api-inference.huggingface.co/models/meta-llama/Llama-3.1-8B-Instruct/v1/chat/completions";

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer '.$GLOBALS['HUGGINGFACE']
            ];

            $data['model'] =  "meta-llama/Llama-3.1-8B-Instruct";
            $data['messages'] = $arrayCompletion;
            $data['max_tokens'] = 200;
            $data['min_new_tokens'] = 200;
            $data['temperature'] = 0.2;
            $data['do_sample'] = true;
            $data['stream'] = false;

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => json_encode($data)
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
            throw new Exception("Ocorreu em completion: " . $ex->getMessage(), 1);
        }
    }

    public static function completionES($prompt,$entrada)
    {
        try {
            $curl = curl_init();

            $prompt = strip_tags($prompt);
            $entrada = strip_tags($entrada);

            $messagess = [];
            $messagess[0]['role'] = "system";
            $messagess[0]['content'] = "Você é um médico que fornece instruções de forma direta e objetiva.";
            $messagess[1]['role'] = "user";
            $messagess[1]['content'] = $prompt."\nDados de entrada:\n".$entrada;

            $url = "https://api-inference.huggingface.co/models/meta-llama/Llama-3.1-8B-Instruct/v1/chat/completions";

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer '.$GLOBALS['HUGGINGFACE']
            ];

            $data['model'] =  "meta-llama/Llama-3.1-8B-Instruct";
            $data['messages'] = $messagess;
            $data['max_tokens'] = 2048;
            $data['temperature'] = 0.2;
            $data['do_sample'] = true;
            $data['stream'] = false;

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => json_encode($data)
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
                $saida = json_decode($response, true);
                if(isset($saida['choices']) && isset($saida['choices'][0]['message']['content']) && !empty($saida['choices'][0]['message']['content']))return $saida['choices'][0]['message']['content'];
                else if(isset($saida['error'])){
                    throw new Exception($saida['error']);
                }
                else{
                    throw new Exception("Saida LLM Vazia HugginFace");
                }
            }
        } catch (\Exception $ex) {
            throw new Exception("<br>Ocorreu em completion HuggingFace: " . $ex->getMessage(), 1);
        }
    }
    public static function completionESR($prompt,$entrada,$rag)
    {
        try {
            $curl = curl_init();

            $prompt = strip_tags($prompt);
            $entrada = strip_tags($entrada);
            if(!empty($rag))$rag = strip_tags($rag);

            $messagess = [];
            $messagess[0]['role'] = "system";
            $messagess[0]['content'] = "Você é um médico que fornece instruções de forma direta e objetiva.";
            $messagess[1]['role'] = "user";
            $messagess[1]['content'] = $prompt."\nUse o contexto a seguir, se necessário: ".$rag."\nDados de entrada:\n".$entrada;

            $url = "https://api-inference.huggingface.co/models/meta-llama/Llama-3.1-8B-Instruct/v1/chat/completions";

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer '.$GLOBALS['HUGGINGFACE']
            ];

            $data['model'] =  "meta-llama/Llama-3.1-8B-Instruct";
            $data['messages'] = $messagess;
            $data['max_tokens'] = 2048;
            $data['temperature'] = 0.2;
            $data['do_sample'] = true;
            $data['stream'] = false;

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => json_encode($data)
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
                $saida = json_decode($response, true);
                if(isset($saida['choices']) && isset($saida['choices'][0]['message']['content']) && !empty($saida['choices'][0]['message']['content']))return $saida['choices'][0]['message']['content'];
                else if(isset($saida['error'])){
                    throw new Exception($saida['error']);
                }
                else{
                    throw new Exception("Saida LLM Vazia HugginFace");
                }
            }
        } catch (\Exception $ex) {
            throw new Exception("<br>Ocorreu em completion HuggingFace: " . $ex->getMessage(), 1);
        }
    }

    public static function sumarization($prompt,$entrada)
    {
        try {
            $curl = curl_init();

            $prompt = strip_tags($prompt);
            $entrada = strip_tags($entrada);

            $messagess = [];
            $messagess[0]['role'] = "system";
            $messagess[0]['content'] = $prompt;
            $messagess[1]['role'] = "user";
            $messagess[1]['content'] = $entrada;

            $url = "https://api-inference.huggingface.co/models/meta-llama/Llama-3.1-8B-Instruct/v1/chat/completions";

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer '.$GLOBALS['HUGGINGFACE']
            ];

            $data['model'] =  "meta-llama/Llama-3.1-8B-Instruct";
            $data['messages'] = $messagess;
            $data['max_tokens'] = 2048;
            $data['temperature'] = 0.2;
            $data['do_sample'] = true;
            $data['stream'] = false;

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POSTFIELDS => json_encode($data)
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
                $saida = json_decode($response, true);
                if(isset($saida['choices']) && isset($saida['choices'][0]['message']['content']) && !empty($saida['choices'][0]['message']['content']))return $saida['choices'][0]['message']['content'];
                else if(isset($saida['error'])){
                    throw new Exception($saida['error']);
                }
                else{
                    throw new Exception("Saida LLM Vazia HugginFace");
                }
            }
        } catch (\Exception $ex) {
            throw new Exception("<br>Ocorreu em completion HuggingFace: " . $ex->getMessage(), 1);
        }
    }
}