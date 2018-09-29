<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;

class FileHelper
{
    public static $shopLogoImageFilePath = '/shop/logo/';
    public static $shopDetailImageFilePath = '/shop/detail/';
    public static $giftResultImagePath = '/shop/gift/';
    public static $adImagePath = '/shop/ad/';

    public static $groupImagePath = '/shop/groupon/';
    
    public static function shopLogoImage($file) 
    {
        return static::uploadImage(static::$shopLogoImageFilePath, $file);
    }

    public static function shopDetailImage($file) 
    {
        return static::uploadImage(static::$shopDetailImageFilePath, $file);
    }

    public static function giftResultImage($file) 
    {
        return static::uploadImage(static::$giftResultImagePath, $file);
    }

    public static function shopADImage($file) 
    {
        return static::uploadImage(static::$adImagePath, $file);
    }

    public static function groupOnImage($file)
    {
        return static::uploadImage(static::$groupImagePath, $file,true);
    }
    public static function uploadImage($filePath, $file ,$temp=false)
    {
        $mediaHost = Config::get('shop.media.host');
        $mediaUser = Config::get('shop.media.user');
        $mediaPass = Config::get('shop.media.pass');
        $mediaRoot = Config::get('shop.media.root');
        $mediaPath = Config::get('shop.media.path');
        if($temp){
            $mediaPath = Config::get('shop.media.tempPath');
        }
        $mediaIp = Config::get('shop.media.ip');

        $clientName = $file->getClientOriginalName();
        $name       = md5($clientName.microtime());
        $extension  = $file->getClientOriginalExtension();
        $mimeType   = $file->getClientMimeType();
        $size       = $file->getClientSize();
        $fullPath   = $mediaPath.$filePath.$name.'.'.$extension;
        $url        = $mediaHost.$fullPath;

        list($imageWidth, $imageHeight) = getimagesize($file);

        $filesystem = new Filesystem(new SftpAdapter([
            'host'          => $mediaIp,
            'port'          => 22,
            'username'      => $mediaUser,
            'password'      => $mediaPass,
            'root'          => $mediaRoot,
        ]));
        
        $stream = fopen($file->getRealPath(), 'r+');
        $filesystem->put($fullPath, $stream);
        
        return [
            'client_name'   => $clientName,
            'name'          => $name,
            'extension'     => $extension,
            'mine_type'     => $mimeType,
            'size'          => $size,
            'full_path'     => $fullPath,
            'url'           => $url,
            'image_width'   => $imageWidth,
            'image_height'  => $imageHeight,
        ];
    }
}
