<?php

namespace App\Livewire\Frontend;

use Livewire\Attributes\Layout;
use Livewire\Component;

class ContactComponent extends Component
{
    #[Layout('frontend.layouts.app')]

    public function render()
    {
        return view('frontend.pages.contact');
    }
}
