<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use App\Exceptions\ThirdPartyException;
use Illuminate\Http\UploadedFile;

class UtilService
{
    public function http($url, $method, $options = [])
    {
        $client = new Client();

        $method = strtolower($method);

        try {
            switch ($method) {
                case 'get':
                case 'post':
                case 'put':
                case 'delete':
                default:
                    $response = $client->{$method}($url, $options);
                    break;
            }
        }catch (\Exception $e){

            $response = $e->getResponse();

            if(!method_exists($response, 'getStatusCode')){
                throw $e;
            }

            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody()->getContents(), true);

            throw new ThirdPartyException('', $statusCode, null, null, $responseData);
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    public function sendToMicroservice($url, $method, $jwt = null, $params = [])
    {
        $method = strtolower($method);
        $options = [];

        if($jwt){
            $options['headers'] = [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$jwt
            ];
        }

        if($method === 'post' || $method === 'put'){

            $shouldUseMultipart = false;
            foreach ($params as $value){

                if($value instanceof UploadedFile){
                    $shouldUseMultipart = true;
                    break;
                }
            }

            if($shouldUseMultipart){

                $multipart = [];
                foreach ($params as $name => $value){

                    if($value instanceof UploadedFile){
                        $multipart[] = [
                            'name' => $name,
                            'contents' => fopen($value, 'r'),
                            'filename' => $value->getClientOriginalName()
                        ];

                    } else {
                        $multipart[] = [
                            'name' => $name,
                            'contents' => $value,
                        ];
                    }
                }

                $options['multipart'] = $multipart;

                if($method === 'put'){
                    $method = 'post';
                }

            } else {
                if($method === 'put'){
                    $options['json'] = $params;

                } else {
                    $options['form_params'] = $params;
                }
            }
        }

        switch ($method) {
            case 'get':
                $options['query'] = $params;
                break;

            case 'post':
            case 'put':
               break;

            case 'delete':
            default:
                $options['json'] = $params;
                break;
        }

        return $this->http($url, $method, $options);
    }

    public function formatApiData($listData)
    {
        $listData = is_array($listData) ? $listData : $listData->toArray();

        foreach ($listData as &$data) {


        }

        return $listData;
    }
}
