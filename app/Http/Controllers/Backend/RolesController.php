<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\RolesRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    public $module = "roles";

    public function index(Request $request)
    {
        abort_unless(\Gate::allows($this->module . '_access'), 403);

        if ($request->get('draw')) {
            $list = Role::with('permissions')->select(
                'id',
                'title'
            );

            return $this->_datatable($list);
        }

        return view('admin.view.' . $this->module . '.index');
    }

    public function show(Role $role)
    {
        abort_unless(\Gate::allows($this->module . '_show'), 403);

        $role->load('permissions');

        return view('admin.view.' . $this->module . '.show', compact('role'));
    }

    public function create()
    {
        abort_unless(\Gate::allows($this->module . '_create'), 403);

        $permissions = Permission::all()->pluck('title', 'id');

        return view(
            'admin.view.' . $this->module . '.create',
            ['permissions' => $permissions, 'module' => $this->module]
        );
    }

    public function store(RolesRequest $request)
    {
        abort_unless(\Gate::allows($this->module . '_create'), 403);

        $role = Role::create($request->only('title'));

        $role->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.' . $this->module . '.index');
    }

    public function edit(Role $role)
    {
        abort_unless(\Gate::allows($this->module . '_edit'), 403);

        $permissions = Permission::all()->pluck('title', 'id');

        $role->load('permissions');

        return view(
            'admin.view.' . $this->module . '.edit',
            ['permissions' => $permissions, 'role' => $role, 'module' => $this->module]
        );
    }

    public function update(RolesRequest $request, Role $role)
    {
        abort_unless(\Gate::allows($this->module . '_edit'), 403);

        $role->update($request->all());

        $role->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.' . $this->module . '.index');
    }

    public function destroy(Role $role)
    {
        abort_unless(\Gate::allows($this->module . '_delete'), 403);

        $role->delete();

        return back();
    }

    private function _datatable(Builder $list)
    {
        return DataTables::of($list)
            ->filterColumn(
                'actions',
                function ($query, $keyword) {
                    $query->whereRaw($this->module . '.id like ?', ['%' . $keyword . '%']);
                }
            )
            ->addColumn(
                'actions',
                function ($model) {
                    return view(
                        'admin.view.' . $this->module . '.partials.control_buttons',
                        ['model' => $model, 'type' => $this->module, 'without_delete' => false]
                    )->render();
                }
            )
            ->addColumn(
                'permission_id',
                function ($test) {
                    return view(
                        'admin.view.' . $this->module . '.test',
                        ['list' => $test,'type' => 'user']
                    )->render();
                }
            )
            ->rawColumns(['actions','permission_id'])
            ->make();
    }
}
