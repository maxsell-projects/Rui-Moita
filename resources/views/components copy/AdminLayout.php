<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // Certifique-se de que o arquivo resources/views/layouts/admin.blade.php existe
        return view('layouts.admin');
    }
}