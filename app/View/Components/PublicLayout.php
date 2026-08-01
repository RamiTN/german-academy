<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PublicLayout extends Component
{
    public function __construct(
        public ?string $seoTitle = null,
        public ?string $seoDescription = null,
        public ?string $seoCanonical = null,
        public ?string $seoImage = null,
        public ?string $seoRobots = null,
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.public');
    }
}
