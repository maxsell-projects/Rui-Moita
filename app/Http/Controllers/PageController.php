<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Consultant;

class PageController extends Controller
{
    public function home()
    {
        // Pega os 6 imóveis mais recentes para a Home
        $properties = Property::latest()->take(6)->get();
        return view('pages.home', compact('properties'));
    }

    public function about()
    {
        return view('pages.about');
    }
    
    public function team()
    {
        // Lista apenas consultores ativos
        $consultants = Consultant::where('is_active', true)->orderBy('order')->get();
        return view('pages.team', compact('consultants'));
    }

    public function contact()
    {
        return view('pages.contact');
    }
}