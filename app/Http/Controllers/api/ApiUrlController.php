<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ApiUrlController extends Controller
{
    public function index()
    {
        $urls = Url::orderBy('id', 'desc')->get();
        $response = [
            'urls' => $urls
        ];
        return response()->json($response, 200);
    }

    public function short(Request $request)
    {
        $validator = Validator::make($request->all(),['url' => 'required']);
        if ($validator->fails()){
            $response = [
                'status' => 'Please Enter your url !'
            ];
            return response()->json($response, 200);
        }
        $url = Url::whereUrl($request->url)->first();
        if ($url == null) {
            $short = $this->generateShortUrl();
            $newUrl = Url::create([
                'url' => $request->url,
                'short_url' => $short,
            ]);
            $response = [
                'status' => 'New link Successfully Added !'
            ];
        } else {
            $response = [
                'status' => 'Link already Exist !'
            ];
        }

        return response()->json($response, 200);


    }

    private function generateShortUrl()
    {

        $result = base_convert(rand(1000, 99999), 10, 36);
        $data = Url::where('short_url', $result)->first();

        if ($data != null) {
            $this->generateShortUrl();
        }
        return $result;

    }

    public function shortLink($link)
    {
        $url = Url::where('short_url', $link)->first();
        $response = [
            'link' => $url->url
        ];
        return response()->json($response, 200);
    }
}
