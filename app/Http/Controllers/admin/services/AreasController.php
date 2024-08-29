<?php

namespace App\Http\Controllers\admin\services;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class AreasController extends Controller
{
    public function index()
    {
        if (!userCan('areas_view')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        $areas = Area::orderBy('name','asc')->paginate(25);
        return view('AdminPanel.services.areas.index',[
            'active' => 'areas',
            'title' => trans('common.areas'),
            'areas' => $areas,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.areas')
                ]
            ]
        ]);
    }



    public function store(Request $request)
    {
        if (!userCan('areas_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token']);

        $area = Area::create($data);
        if ($area) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function update(Request $request, $id)
    {
        if (!userCan('areas_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $area = Area::find($id);
        $data = $request->except(['_token']);

        $update = Area::find($id)->update($data);
        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function delete($id)
    {
        if (!userCan('areas_delete')) {
            return Response::json("false");
        }
        $area = Area::find($id);
        if ($area->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}
