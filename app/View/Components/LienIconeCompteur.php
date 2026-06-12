<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class LienIconeCompteur extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $destination,
        public string $title,
        public ?int $count = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.lien-icone-compteur');
    }
}
