<?php

namespace App\Http\ViewComposers;

use App\Models\Category;
use Illuminate\View\View;

class NavigationComposer
{
    /**
     * Vincular datos a la vista.
     * Este composer se ejecuta automáticamente antes de renderizar las vistas.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Compartir categorías con las vistas que lo necesiten
        // Se cachean automáticamente durante la petición
        $view->with('categories', Category::all());
    }
}
