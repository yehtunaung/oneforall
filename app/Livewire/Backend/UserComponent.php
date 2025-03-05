<?php

namespace App\Livewire\Backend;

use Livewire\Attributes\Layout;
use Livewire\Component;

class UserComponent extends Component
{
    #[Layout('backend.layouts.app')]
    public function render()
    {
        return view('backend.admin.user.index');
    }
}
