<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MultiDomainController extends Controller
{
    public function login($domain, $tld, Request $request)
    {
        $data['domain'] = $domain;
        $data['tld'] = $tld;
        return view("compro.$domain.login",$data);
    }
    public function index($domain, $tld, Request $request)
    {
        $data['domain'] = $domain;
        $data['tld'] = $tld;
        return view("compro.$domain.index",$data);

        return view("compro.beautypro.index");
    }

    public function about($domain, $tld, Request $request)
    {
        return view("compro.beautypro.about");
    }

    public function gallery($domain, $tld, Request $request)
    {
        return view("compro.beautypro.gallery");
    }

    public function contact($domain, $tld, Request $request)
    {
        return view("compro.beautypro.contact");
    }

    public function product($domain, $tld, Request $request)
    {
        return view("compro.beautypro.product");
    }
    public function services($domain, $tld, Request $request)
    {
        return view("compro.beautypro.service");
    }
}
