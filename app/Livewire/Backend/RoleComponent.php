<?php

namespace App\Livewire\Backend;

use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;
use App\Services\RoleServices;
use Livewire\Attributes\Layout;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
class RoleComponent extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Layout('backend.layouts.app')]
    public $currentPage = 'list', $title, $role_id;
    protected $roleService;
    public $permissions = [];
    public $selectedPermissions = [];
    public $search='';


    public function boot(RoleServices $roleService)
    {
        $this->roleService = $roleService;
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
    }

    public function mount()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');

        if (request()->is('admin/role/create')) {
            $this->currentPage = 'create';
        } elseif (request()->is('admin/role/edit/*')) {
            $this->edit(request()->route('id'));
            $this->currentPage = 'edit';
        } elseif (request()->is('admin/role/show/*')) {
            $this->show(request()->route('id'));
            $this->currentPage = 'show';
        } else {
            $this->currentPage = 'list';
        }
    }
    public function create()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $this->resetPage();
        $this->currentPage = 'create';
    }
    public function store()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $role = $this->roleService->createRole([
            'title' => $this->title,
        ]);

        $role->permissions()->sync($this->selectedPermissions);

        session()->flash('message', 'Role created successfully!');
        session()->flash('type', 'success');
        return $this->redirect('/admin/role', navigate: true);
    }
    public function edit($id)
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $role = $this->roleService->getRoleById($id);
        $this->role_id = $role->id;
        $this->title = $role->title;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
        $this->currentPage = 'edit';
    }

    public function update()
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $role = $this->roleService->updateRole($this->role_id, [
            'title' => $this->title,
        ]);
        $role->permissions()->sync($this->selectedPermissions);
        session()->flash('message', 'Role updated successfully!');
        session()->flash('type', 'success');

        return $this->redirect('/admin/role', navigate: true);
    }

    public function show($id)
    {
        abort_if(Gate::denies('role_show'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $role = $this->roleService->getRoleById($id);
        $this->role_id = $role->id;
        $this->title = $role->title;
        $this->selectedPermissions = $role->permissions->pluck('title')->toArray();
        $this->currentPage = 'show';
    }
    public function delete($id)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $this->roleService->deleteRole($id);

        session()->flash('message', 'Role deleted successfully!');
        session()->flash('type', 'success');
        return $this->redirect('/admin/role', navigate: true);
    }
    public function render()
    {
        $this->permissions = Permission::all();
        switch ($this->currentPage) {
            case 'create':
                return view('backend.admin.role.create',['permissions'=>$this->permissions]);
            case 'edit':
                return view('backend.admin.role.edit',['permissions'=>$this->permissions]);
            case 'show':
                return view('backend.admin.role.show',['permissions'=>$this->permissions]);
            default:
                return view('backend.admin.role.index',['permissions'=>$this->permissions], [
                    'roles' => $this->roleService->getPaginatedRole(5,$this->search),
                ]);
        }
    }
}
