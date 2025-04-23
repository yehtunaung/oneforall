<?php

namespace App\Livewire\Backend;

use App\Services\PermissionServices;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class PermissionComponent extends Component
{
    use WithPagination, WithoutUrlPagination;
    #[Layout('backend.layouts.app')]
    public $currentPage = 'list', $title, $permission_id;
    public $search ='';

    protected $permissionService;

    public function boot(PermissionServices $permissionService)
    {
        $this->permissionService = $permissionService;
        abort_if(Gate::denies('permission_access'),Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
    }
    public function mount()
    {
        abort_if(Gate::denies('permission_access'),Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        if (request()->is('admin/permission/create')) {
            $this->currentPage = 'create';
        } elseif (request()->is('admin/permission/edit/*')) {
            $this->edit(request()->route('id'));
            $this->currentPage = 'edit';
        } elseif (request()->is('admin/permission/show/*')) {
            $this->show(request()->route('id'));
            $this->currentPage = 'show';
        } else {
            $this->currentPage = 'list';
        }
    }

    public function create()
    {
        abort_if(Gate::denies('permission_create'),Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $this->resetPage();
        $this->currentPage = 'create';
    }

    public function store()
    {
        abort_if(Gate::denies('permission_create'),Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $this->permissionService->createPermission([
            'title' => $this->title,
        ]);
        session()->flash('message', 'Permission created successfully!');
        session()->flash('type', 'success');
        return $this->redirect('/admin/permission', navigate: true);
    }

    public function edit($id)
    {
        abort_if(Gate::denies('permission_edit'),Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $permission = $this->permissionService->getPermissionById($id);
        $this->permission_id = $permission->id;
        $this->title = $permission->title;
        $this->currentPage = 'edit';
    }

    public function update()
    {
        abort_if(Gate::denies('permission_edit'),Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $this->permissionService->updatePermission($this->permission_id, [
            'title' => $this->title,
        ]);

        session()->flash('message', 'Permission updated successfully!');
        session()->flash('type', 'success');

        return $this->redirect('/admin/permission', navigate: true);
    }

    public function show($id)
    {
        abort_if(Gate::denies('permission_show'),Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $permission = $this->permissionService->getPermissionById($id);
        $this->permission_id = $permission->id;
        $this->title = $permission->title;
        $this->currentPage = 'show';
    }

    public function delete($id)
    {
        abort_if(Gate::denies('permission_delete'),Response::HTTP_FORBIDDEN, '403 FORBIDDEN');
        $this->permissionService->deletePermission($id);

        session()->flash('message', 'Permission deleted successfully!');
        session()->flash('type', 'success');
        return $this->redirect('/admin/permission', navigate: true);
    }

    public function render()
    {
        switch ($this->currentPage) {
            case 'create':
                return view('backend.admin.permission.create');
            case 'edit':
                return view('backend.admin.permission.edit');
            case 'show':
                return view('backend.admin.permission.show');
            default:
                return view('backend.admin.permission.index', [
                    'permissions' => $this->permissionService->getPaginatedPermissions(5,$this->search),
                ]);
        }
    }
}
