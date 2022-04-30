<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UrlController extends Controller
{

    public function index()
    {
        $urls = Url::orderBy('id', 'desc')->get();
        return view('url.short', compact('urls'));
    }

    public function short(Request $request)
    {
        $request->validate([
            'url' => 'required'
        ]);
        $url = Url::whereUrl($request->url)->first();
        if ($url == null) {
            $short = $this->generateShortUrl();
            Url::create([
                'url' => $request->url,
                'short_url' => $short,
            ]);
            Session::flash('message', 'New link Added !');
            $url = Url::whereUrl($request->url)->first();
        }
        return back();

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
        return redirect($url->url);
    }
}
