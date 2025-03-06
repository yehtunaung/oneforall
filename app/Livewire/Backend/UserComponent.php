<?php

namespace App\Livewire\Backend;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination;

    #[Layout('backend.layouts.app')]
    public $users;
    public function render()
    {
        $this->users = User::get();
        return view('backend.admin.user.index', ['users' => $this->users]);
    }
}
