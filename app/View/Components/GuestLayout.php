<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return View
     */
    public function render(): View
    {
        $view = view('layouts.guest');
        if ($view instanceof View) {
            return $view;
        }
        Throw new \RuntimeException;
    }
}
