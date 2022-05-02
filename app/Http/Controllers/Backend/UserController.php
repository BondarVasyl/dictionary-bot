<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\User\UserCreateRequest;
use App\Http\Requests\Backend\User\UserUpdateRequest;
use App\Http\Requests\Backend\User\PasswordChange;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public $module = "user";

    public function index(Request $request)
    {
        abort_unless(\Gate::allows($this->module . '_access'), 403);

        $type = $request->get('type');

        if ($request->get('draw')) {
            $list = User::with('roles');
            $list = $type == 'app'
                ? $list->whereDoesntHave('roles')
                : $list->whereHas('roles');

            $list = $list->select(
                [
                    'id',
                    'email',
                    'created_at'
                ]
            )->orderByDesc('created_at');

            return $this->_datatable($list, $type);
        }

        return view('admin.view.' . $this->module . '.index', ['active_tab' => $type]);
    }

    public function create()
    {
        abort_unless(\Gate::allows($this->module . '_create'), 403);

        $data['model'] = new User();

        $data['without_password_change'] = false;

        $data['module'] = $this->module;

        $roles = Role::all()->pluck('title', 'id');

        return view('admin.view.' . $this->module . '.create', compact('roles'), $data);
    }

    public function store(UserCreateRequest $request)
    {
        abort_unless(\Gate::allows($this->module . '_create'), 403);

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        $user->profile()->create(['name' => $input['name']]);

        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.' . $this->module . '.index');
    }

    public function edit(User $user)
    {
        abort_unless(\Gate::allows($this->module . '_edit'), 403);

        $model = User::findOrFail($user->id);

        $roles = Role::all()->pluck('title', 'id');

        $user->load('roles');

        $data['module'] = $this->module;

        $data['without_password_change'] = false;

        $data['model'] = $model;

        return view('admin.view.' . $this->module . '.edit', compact('roles', 'user'), $data);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        abort_unless(\Gate::allows($this->module . '_edit'), 403);

        $data = $request->except('_token', '_method');


        $user->update(Arr::only($data, ['email']));

        if ($user->profile) {
            $user->profile()->update(Arr::only($data, ['name']));
        } else {
            $user->profile()->create(Arr::only($data, ['name']));
        }

        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.' . $this->module . '.index');
    }

    public function show(Request $request, User $user)
    {
        abort_unless(\Gate::allows($this->module . '_show'), 403);

        $user->load('roles');

        $data['without_password_change'] = false;

        $display_type = $request->get('display_type');

        $view = 'admin.view.' . $this->module . '.show';

        if ($display_type && $display_type == 'app') {
            $view .= '_app_user';
        }

        return view($view, compact('user'));
    }

    public function destroy(User $user)
    {
        abort_unless(\Gate::allows($this->module . '_delete'), 403);

        $user->delete();

        return back();
    }

    public function getNewPassword($id)
    {
        $data['model'] = User::find($id);

        $data['module'] = $this->module;

        $data['without_password_change'] = false;

        if (!$data['model']) {
            return redirect()->route('admin.user.index');
        }

        return view('admin.view.' . $this->module . '.new_password', $data);
    }

    public function postNewPassword($id, PasswordChange $request)
    {
        $user = User::find($id);

        $user->update(['password' => Hash::make($request->input('password'))]);

        auth()->logout();

        return redirect()->route('admin.user.edit', $id);
    }

    private function _datatable(Builder $list, $type)
    {
        return DataTables::of($list)
            ->filterColumn(
                'actions',
                function ($query, $keyword) {
                    $query->whereRaw('users.id like ?', ['%' . $keyword . '%']);
                }
            )
            ->addColumn(
                'actions',
                function ($model) use ($type) {
                    return view(
                        'admin.view.' . $this->module . '.partials.control_buttons',
                        ['model' => $model, 'type' => 'user', 'without_delete' => false, 'display_type' => $type]
                    )->render();
                }
            )
            ->addColumn(
                'roles_id',
                function ($roles) {
                    return view(
                        'admin.view.' . $this->module . '.partials.roles',
                        ['list' => $roles, 'type' => 'user']
                    )->render();
                }
            )
            ->editColumn(
                'email',
                function ($model) {
                    return $model->email ? $model->email : $model->profile->username;
                }
            )
            ->rawColumns(['actions', 'roles_id'])
            ->make();
    }
}
