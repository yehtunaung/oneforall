<?php

namespace App\Livewire\Backend;

use App\Models\Role;
use App\Services\UserServices;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Layout('backend.layouts.app')]
    public $currentPage = 'list', $name, $email, $password, $user_id, $currentUrl, $role_title;
    public $roles = [], $availableRoles;
    public $roleFilter = '';
    public $search ='';



    protected $userService;

    public function boot(UserServices $userService)
    {
        $this->userService = $userService;
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
    }

    public function mount()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $this->availableRoles = Role::all();

        if (request()->is('admin/users/create')) {
            $this->currentPage = 'create';
        } elseif (request()->is('admin/users/edit/*')) {
            $this->edit(request()->route('id'));
            $this->currentPage = 'edit';
            // $this->loadUserData();
        } elseif (request()->is('admin/users/show/*')) {
            $this->show(request()->route('id'));
            $this->currentPage = 'show';
        } else {
            $this->currentPage = 'list';
        }
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $this->resetPage();
        $this->currentPage = 'create';
    }


    public function store()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $user = $this->userService->createUser([
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->roles,
            'password' => $this->password
        ]);

        $user->roles()->sync($this->roles);

        session()->flash('message', 'User created successfully!');
        session()->flash('type', 'success');
        return $this->redirect('/admin/users', navigate: true);
    }

    public function edit($id)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $user = $this->userService->getUserById($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->roles = $user->roles->pluck('id')->toArray();
        $this->currentPage = 'edit';
    }

    public function update()
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $user = User::findOrFail($this->user_id);
        $user = $this->userService->updateUser($this->user_id, [
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->roles,
            'password' => $this->password ? bcrypt($this->password) : $user->password,
        ]);
        $user->roles()->sync($this->roles);
        session()->flash('message', 'User updated successfully!');
        session()->flash('type', 'success');
        return $this->redirect('/admin/users', navigate: true);
    }


    private function show($id)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $user = $this->userService->getUserById($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role_title = $user->roles->pluck('title')->toArray();
        $this->currentPage = 'show';
    }
    public function delete($id)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $this->userService->deleteUser($id);
        session()->flash('message', 'User deleted successfully!');
        session()->flash('type', 'success');
        return $this->redirect('/admin/users', navigate: true);
    }


    public function filterUsers() {}

    public function render()
    {
        switch ($this->currentPage) {
            case 'create':
                return view('backend.admin.user.create', [
                    'availableRoles' => $this->availableRoles,
                ]);
            case 'edit':
                return view('backend.admin.user.edit', [
                    'availableRoles' => $this->availableRoles,
                ]);
            case 'show':
                return view('backend.admin.user.show');
            default:
                return view('backend.admin.user.index', [
                    'availableRoles' => $this->availableRoles,
                    'users' => $this->userService->getAllUsers(10, $this->roleFilter,$this->search),
                ]);
        }
    }
}
