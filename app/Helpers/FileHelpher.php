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

    public static function uploadImage($filePath, $file)
    {
        $mediaHost = Config::get('bw.media.host');
        $mediaUser = Config::get('bw.media.user');
        $mediaPass = Config::get('bw.media.pass');
        $mediaRoot = Config::get('bw.media.root');
        $mediaPath = Config::get('bw.media.path');
        $mediaIp = Config::get('bw.media.ip');

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
