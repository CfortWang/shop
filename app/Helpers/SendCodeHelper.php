<?php

namespace App\Helpers;


class SendCodeHelper
{

    public static function send($callingCode,$phoneNum,$code)
    {
        $smscontent['zh']  = '您的验证码是: 【$】';
        $smscontent['en']  = 'Your verification code is 【$】';
        
        if ($callingCode == 86) {
            $lang = 'zh';
            $url = "http://106.ihuyi.com/webservice/sms.php?method=Submit";
            $mobile = $phoneNum;
            $account = env('ISMS_IHUYI_ACCOUNT_CHINA', '');
            $password = env('ISMS_IHUYI_PASSWORD_CHINA', '');
        } else {
            $lang = 'en';
            $url = "http://api.isms.ihuyi.com/webservice/isms.php?method=Submit";
            $mobile = $callingCode.' '.$phoneNum;
            $account = env('ISMS_IHUYI_ACCOUNT', '');
            $password = env('ISMS_IHUYI_PASSWORD', '');
        }
        $content = $smscontent[$lang];
        $content = str_replace('$', $code, $content);
        $postFields = "";
        $postFields .= "&"."format=json";
        $postFields .= "&"."account=".$account;
        $postFields .= "&"."password=".$password;
        $postFields .= "&"."mobile=".$mobile;
        $postFields .= "&"."content=".rawurlencode($content);
        
        $curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

}
