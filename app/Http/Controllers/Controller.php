<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    protected static $httpOK = 200;               
    protected static $httpCreated = 201;          
    protected static $httpAccepted = 202;         
    protected static $httpNoContent = 204;        

    protected static $httpBadRequest = 400;       
    protected static $httpUnauthorized = 401;     
    protected static $httpForbidden = 403;        
    protected static $httpNotFound = 404;         
    protected static $httpMethodNotAllowed = 405; 
    protected static $httpNotAcceptable = 406;    
    protected static $httpTimeOut = 408;          
    protected static $httpConflict = 409;         
    protected static $httpGone = 410;             

    protected static $httpServerError = 500;      
    
    protected function responseOK($msg, $data = [])
    {
        if(is_array($data)){
            array_walk_recursive($data, function (& $val, $key ) {
                if ($val === null) {
                    $val = '';
                }    
            });
        }
        header('Access-Control-Allow-Origin:http://wang.beanpop.cn:8081');
        header('Access-Control-Allow-Headers:Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN');
        header('Access-Control-Expose-Headers:Authorization, authenticated');
        header('Access-Control-Allow-Methods:GET, POST, PATCH, PUT, OPTIONS');
        header('Access-Control-Allow-Credentials:true');
        return response()->json([
            'code'      =>  static::$httpOK,
            'message'   => $msg,
            'data'      => $data,
        ], static::$httpOK, [], JSON_UNESCAPED_UNICODE);
    }

    protected function responseNoContent($msg, $data = [])
    {
        return response()->json([
            'code'    => static::$httpNoContent,
            'message'   => $msg,
            'data'      => $data,
        ], static::$httpOK, [], JSON_UNESCAPED_UNICODE);
    }

    protected function responseBadRequest($msg, $data = [])
    {
        $code = static::$httpBadRequest;
        return response()->json([
            'code'      => $code,
            'message'   => $msg,
            'data'      => $data,
        ], static::$httpOK, [], JSON_UNESCAPED_UNICODE);
    }

	protected function responseForbidden($msg, $data = [])
    {
        return response()->json([
            'code'      =>  static::$httpForbidden,
            'message'   => $msg,
            'data'      => $data,
        ], static::$httpOK, [], JSON_UNESCAPED_UNICODE);
    }

    protected function responseNotFound($msg, $data = [])
    {
        return response()->json([
            'code'    => static::$httpNotFound,
            'message'   => $msg,
            'data'      => $data,
        ], static::$httpOK, [], JSON_UNESCAPED_UNICODE);
    }

    protected function responseServerError($msg, $data = [])
    {
        return response()->json([
            'code'    => static::$httpServerError,
            'message'   => $msg,
            'data'      => $data,
        ], static::$httpOK, [], JSON_UNESCAPED_UNICODE);
    }

    protected function responseGone($msg, $data = [])
    {
        return response()->json([
            'code'    => static::$httpGone,
            'message'   => $msg,
            'data'      => $data,
        ], static::$httpOK, [], JSON_UNESCAPED_UNICODE);
    }

    protected function responseCustom($code,$msg, $data = [])
    {
        return response()->json([
            'code'    => $code,
            'message'   => $msg,
            'data'      => $data,
        ], static::$httpOK, [], JSON_UNESCAPED_UNICODE);
    }

    protected function response4DataTables($items, $recordsTotal, $recordsFiltered)
    {
        $totalCnt = count($items);

        if ($totalCnt == 0 || $recordsTotal === 0) {
            return $this->responseOK('',[
                'data'              => $items,
                'recordsTotal'      => $recordsTotal,
                'recordsFiltered'   => $recordsFiltered,
            ]);
        } else {
            return $this->responseOK('', [
                'data'              => $items,
                'recordsTotal'      => $recordsTotal,
                'recordsFiltered'   => $recordsFiltered,
            ]);
        }
    }
    
}