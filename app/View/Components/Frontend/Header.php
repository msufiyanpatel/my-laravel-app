<?php

namespace App\View\Components\Frontend;

use App\Models\Page;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    public $about;
    public $services;
    public $contact;
    /**
     * Create a new component instance.
     */
    public function __construct(Page $page)
    {
        $this->about = $page->where('slug', 'about')->where('status', 1)->first();
        $this->contact = $page->where('slug', 'contact')->where('status', 1)->first();
        $this->services = $page->where('slug', 'services')->where('status', 1)->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.header');
    }
}
