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
    public $currentPage = 'list' , $name , $email , $password , $user_id , $currentUrl;
    public function mount()
    {
        if (request()->is('admin/users/create')) {
            $this->currentPage = 'create';
        } elseif (request()->is('admin/users/edit/*')) {
            $this->currentPage = 'edit';
        } else {
            $this->currentPage = 'list';
        }
    }
    public function create()
    {
        $this->resetPage(); 
        $this->currentPage = 'create';
    }
public function store()
{
    $this->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6'
    ]);

    User::create([
        'name' => $this->name,
        'email' => $this->email,
        'password' => bcrypt($this->password)
    ]);

    session()->flash('message', 'User created successfully!');
    session()->flash('type', 'success');
    return $this->redirect('/admin/users', navigate: true);

}


    public function render()
    {
        switch ($this->currentPage) {
            case 'create':
                return view('backend.admin.user.create');
            case 'edit':
                return view('backend.admin.user.edit');
            default:
                return view('backend.admin.user.index', [
                    'users' => User::paginate(10) 
                ]);
        }
    }
}
