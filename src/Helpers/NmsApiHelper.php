<?php

namespace Nms\LaravelUtility\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class NmsApiHelper extends Response
{
  protected $api_request;

  public function __construct($app) 
  {
    $this->api_request = $app->request;
  }

  public function logger(callable $callable)
  {
    $callable($this);
  }

  public function unauthorized(string $message = 'Unauthorized')
  {
    return $this->responseData($this->generateResponseMessage($message, Response::HTTP_UNAUTHORIZED), TRUE, Response::HTTP_UNAUTHORIZED);
  }
  
  public function ping()
  {
    return $this->responseData($this->generateResponseMessage('Pong', RESPONSE::HTTP_OK), TRUE, Response::HTTP_OK);
  }

  public function responseSuccess(string $message = 'Success')
  {
    return $this->responseData($this->generateResponseMessage($message, RESPONSE::HTTP_OK), TRUE, Response::HTTP_OK);
  }

  public function responseError(string $message = 'Internal Server Error')
  {
    $parse = $this->isJson($message) ? json_decode($message, true) : $this->generateResponseMessage($message, RESPONSE::HTTP_INTERNAL_SERVER_ERROR);
    $parse['message'] = array_key_exists('message', $parse) ? $parse['message'] : Response::$statusTexts[RESPONSE::HTTP_INTERNAL_SERVER_ERROR];
    $parse['code'] = array_key_exists('code', $parse) ? $parse['code'] : RESPONSE::HTTP_INTERNAL_SERVER_ERROR;
    return $this->responseData($this->generateResponseMessage($parse['message'], $parse['code']), TRUE, $parse['code']);
  }

  public function responseData(array $data, $messageOrBoolean = 'Success', int $code = Response::HTTP_OK)
  {   
    $toArray = (filter_var($messageOrBoolean, FILTER_VALIDATE_BOOLEAN) && $messageOrBoolean === TRUE) ? FALSE : TRUE;

    if ($toArray) {
        $result['data'] = $data;
        $result['message'] = $messageOrBoolean;
    } else {
        $result = $data;
    }
    
    return $this->response($result, $code, $toArray);
  }

  public function response($data, int $code = Response::HTTP_OK, $toArray = true)
  {
    if ($toArray) {
        $result = [
            'message' => '',
            'code' => $code,
            'data' => null,
        ];

        if (is_array($data)) {
            if (array_key_exists('message', $data)) $result['message'] = $data['message'];
            unset($data['message']);
        }

        $result['data'] = $data;

        if (is_array($data)) {
            if (array_key_exists('data', $data)) $result['data'] = $data['data'];
            unset($data['data']);
        }
    } else $result = $data;

    return response()->json($result, $code);
  }

  public function onQueued()
  {
      return $this->responseSuccess('Queued.');
  }

  /**
   * Wrap it to try-catch
   */
  public function validateRequest(array $data, array $rules, array $rename = [])
  {
    $result = [];
    $validator = Validator::make($data, $rules, $rename);
    if ($validator->fails()) {
      $errors = $validator->errors();
      foreach ($errors->all() as $message) {
        $result = [
            'field_error' => true,
            'message' => $message,
            'code' => Response::HTTP_BAD_REQUEST
        ];

        throw new Exception(json_encode($result));
      }
  }
      return true;
  }

  public function isJson(string $string)
  {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
  }

  protected function generateResponseMessage(string $message, int $code)
  {
    return [
      'message' => $message,
      'code' => $code
    ];
  }
}