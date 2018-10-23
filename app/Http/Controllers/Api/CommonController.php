<?php

namespace App\Http\Controllers\Api;

use Validator;
use App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Models\Country;
use App\Models\Province;
use App\Models\City;
use App\Models\Area;


class CommonController extends Controller
{
    public function __construct()
    {

    }

    public function country(Request $request)
    {
        $lang = $request->session()->get('locale');
        $data = Country::select('seq', 'calling_code', 'name_'.$lang.' as name')->orderBy('seq', 'asc')->get();
        if($data){
            return $this->responseOK('success', $data);
        }else{
            return $this->responseNotFound();
        }
    }

    public function province($country)
    {
        $data = Province::where('country', $country)->orderBy('seq', 'asc')->select('seq','name')->get();
        if($data){
            return $this->responseOK('success', $data);
        }else{
            return $this->responseNotFound();
        }
    }

    public function city($province)
    {
        $data = City::where('province', $province)->orderBy('seq', 'asc')->select('seq','name')->get();
        if($data){
            return $this->responseOK('success', $data);
        }else{
            return $this->responseNotFound();
        }
    }

    public function area($city)
    {
        $data = Area::where('city', $city)->orderBy('seq', 'asc')->select('seq','name')->get();
        if($data){
            return $this->responseOK('success', $data);
        }else{
            return $this->responseNotFound();
        }
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
        $request->session()->put('locale', $locale);
        App::setLocale($locale);

        return $this->responseOk('locale set success',[
          'localeResult'   => $locale
        ]);
    }
}
