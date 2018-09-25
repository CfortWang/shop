<?php

namespace App\Http\Controllers\Api;

use Validator;
use App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class LocaleController extends Controller
{
    public function __construct()
    {
    }

    public function setLocale(Request $request)
    {
        $input = Input::only('locale');

        $validator = Validator::make($input, [
            'locale'   => 'required'
        ]);

        if ($validator->fails()) {
            return $this->responseBadRequest('Bad Request', 401);
        }

        $locale = $request->input('locale');
        $request->session()->put('bw.locale', $locale);
        App::setLocale($locale);

        return $this->responseOk('locale set success',[
          'localeResult'   => $locale
        ]);
    }
}
