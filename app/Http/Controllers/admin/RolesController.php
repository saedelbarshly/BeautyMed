<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\roles;
use App\Models\permissions;
use Response;

class RolesController extends Controller
{
    //
    public function index()
    {

        if (!userCan('roles_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $roles = roles::orderBy('id','desc')->paginate(25);
        return view('AdminPanel.roles.index',[
            'active' => 'roles',
            'title' => trans('common.Roles'),
            'roles' => $roles,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Roles')
                ]
            ]
        ]);
    }

    public function store(Request $request)
    {
        if (!userCan('roles_create')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $data = $request->except(['_token','permissions']);
        if ($request->permissions == '') {
            return redirect()->back()
                            ->with('faild',trans('common.youHaveToAssignOnePermissionAtLeast'));
        }
        $role = roles::create($data);
        if ($role) {
            foreach ($request->permissions as $value) {
                $role->permissions()->attach($value);
            }
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }

    public function update(Request $request,$id)
    {
        if (!userCan('roles_edit')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $data = $request->except(['_token','permissions']);
        if ($request->permissions == '') {
            return redirect()->back()
                            ->with('faild',trans('common.youHaveToAssignOnePermissionAtLeast'));
        }
        $role = roles::find($id);
        $role->permissions()->detach();
        $role->update($data);
        foreach ($request->permissions as $value) {
            $role->permissions()->attach($value);
        }
        if ($role) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }

    public function delete($id)
    {
        if (!userCan('roles_delete')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $role = roles::find($id);
        $role->permissions()->detach();
        if ($role->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }




    public function CreatePermission(Request $request)
    {

        if (!userCan('permission_create')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $data = $request->except(['_token']);
        $permission = permissions::create($data);
        if ($permission) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }


}
