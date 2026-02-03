<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function privacy()
    {
        return view('legal.page', [
            'title' => __('legal.privacy.title'),
            'content' => __('legal.privacy.content')
        ]);
    }

    public function terms()
    {
        return view('legal.page', [
            'title' => __('legal.terms.title'),
            'content' => __('legal.terms.content')
        ]);
    }

    public function cookies()
    {
        return view('legal.page', [
            'title' => __('legal.cookies.title'),
            'content' => __('legal.cookies.content')
        ]);
    }

    public function notice()
    {
        return view('legal.page', [
            'title' => __('legal.notice.title'),
            'content' => __('legal.notice.content')
        ]);
    }
}