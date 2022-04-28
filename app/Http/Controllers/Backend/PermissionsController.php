<?php

namespace App\Http\Controllers\Backend;

use App\Facades\FlashMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PermissionsRequest;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermissionsController extends Controller
{
    public $module = "permissions";

    public function index(Request $request)
    {
        abort_unless(\Gate::allows($this->module . '_access'), 403);

        if ($request->get('draw')) {
            $list = Permission::select('id', 'title');

            return $this->_datatable($list);
        }

        return view('admin.view.' . $this->module . '.index');
    }

    public function create(Request $request)
    {
        abort_unless(\Gate::allows($this->module . '_create'), 403);

        return view('admin.view.' . $this->module . '.create', ['module' => $this->module]);
    }

    public function store(PermissionsRequest $request)
    {
        abort_unless(\Gate::allows($this->module . '_create'), 403);

        Permission::create($request->all());

        return redirect()->route('admin.' . $this->module . '.index');
    }

    public function show($id)
    {
        abort_unless(\Gate::allows($this->module . '_show'), 403);

        $model = Permission::whereId($id)->first();

        if (!$model) {
            FlashMessages::add('error', trans('messages.record_not_found'));

            return redirect()->route($this->module . '.index');
        }

        return view('admin.view.' . $this->module . '.show', ['model' => $model]);
    }

    public function edit(Permission $permission)
    {
        abort_unless(\Gate::allows($this->module . '_edit'), 403);

        return view('admin.view.' . $this->module . '.edit', ['permission' => $permission, 'module' => $this->module]);
    }

    public function update(PermissionsRequest $request, Permission $permission)
    {
        abort_unless(\Gate::allows($this->module . '_edit'), 403);

        $permission->update($request->all());

        return redirect()->route('admin.' . $this->module . '.index');
    }

    public function destroy(Permission $permission)
    {
        abort_unless(\Gate::allows($this->module . '_delete'), 403);

        $permission->delete();

        return back();
    }

    private function _datatable(Builder $list)
    {
        return $dataTables = DataTables::of($list)
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
            ->rawColumns(['actions'])
            ->make();
    }
}
