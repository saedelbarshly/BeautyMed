<?php

namespace App\Http\Controllers\admin\accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SafesBanks;
use App\Models\Revenues;
use Response;

class RevenuesController extends Controller
{
    public function index()
    {
        //check if authenticated
        if (!userCan('revenues_view') ) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        //select from DB
        $revenues = Revenues::orderBy('id','desc');  

        //if not allowed to view all just return his branch employees
        if (!userCan('revenues_view')) {
            $revenues = $revenues->where('branch_id',auth()->user()->branch_id);
        } else {
            //filter by branch
            if (isset($_GET['branch_id'])) {
                if ($_GET['branch_id'] != 'all') {
                    $revenues = $revenues->where('branch_id',$_GET['branch_id']);
                }
            }
        }
        //filter by month
        $month = date('m');
        $year = date('Y');


        if (isset($_GET['month']) && isset($_GET['year'])) {
            if ($_GET['month'] != '' && $_GET['year'] != '') {
                $month = $_GET['month'];
                $year = $_GET['year'];
            }
        }

        if (isset($_GET['safe_id']) ) {
            if ($_GET['safe_id'] != 'all' ) {
                $revenues = $revenues->where('safe_id',$_GET['safe_id']);
            }
        }


        $revenues = $revenues->where('month',$month)->where('year',$year);
        $revenues = $revenues->get();

        return view('AdminPanel.accounts.revenues.index',[
            'active' => 'revenues',
            'title' => trans('common.revenues'),
            'revenues' => $revenues,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.revenues')
                ]
            ]
        ]);
    }

    public function store(Request $request)
    {
        if (!userCan('revenues_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        //check if user assigned to branch
        if (auth()->user()->branch == '') {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAssgnedToAnyBranchPleaseContactAdmin'));
        }
        $data = $request->except(['_token','Attachments']);
        $data['DateStr'] = strtotime($request['Date']);
        $data['month'] = date('m',strtotime($request['Date']));
        $data['year'] = date('Y',strtotime($request['Date']));
        $data['UID'] = auth()->user()->id;


        $safe = SafesBanks::find($request['safe_id']);
        $data['branch_id'] = $safe->branch_id;

        $revenue = Revenues::create($data);

        if ($request->Attachments != '') {
            $Files = [];
            if ($request->hasFile('Attachments')) {
                foreach ($request->Attachments as $file) {
                    $Files[] = upload_image_without_resize('revenues/'.$revenue->id , $file );
                }
                $revenue['Files'] = base64_encode(serialize($Files));
                $revenue->update();
            }
        }
        if ($revenue) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function update(Request $request, $id)
    {
        if (!userCan('revenues_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $revenue = Revenues::find($id);
        $data = $request->except(['_token','Attachments']);
        $data['DateStr'] = strtotime($request['Date']);
        $data['month'] = date('m',strtotime($request['Date']));
        $data['year'] = date('Y',strtotime($request['Date']));
        $data['UID'] = auth()->user()->id;

        $safe = SafesBanks::find($request['safe_id']);
        $data['branch_id'] = $safe->branch_id;

        if ($request->Attachments != '') {
            if ($revenue->Files != '') {
                $Files = unserialize(base64_decode($revenue->Files));
            } else {
                $Files = [];
            }
            if ($request->hasFile('Attachments')) {
                foreach ($request->Attachments as $file) {
                    $Files[] = upload_image_without_resize('revenues/'.$id , $file );
                }
                $data['Attachments'] = base64_encode(serialize($Files));
            }
        }

        $update = Revenues::find($id)->update($data);
        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function deletePhoto($id,$photo,$X)
    {
        if (!userCan('revenues_delete_photo')) {
            return Response::json("false");
        }
        $revenue = Revenues::find($id);
        $Files = [];
        if ($revenue->Files != '') {
            $Files = unserialize(base64_decode($revenue->Files));
        }
        if (in_array($photo,$Files)) {
            delete_image('uploads/revenues/'.$id , $photo);
            if (($key = array_search($photo, $Files)) !== false) {
                unset($Files[$key]);
            }
            $revenue['Files'] = base64_encode(serialize($Files));
            $revenue->update();
            return Response::json('photo_'.$X);
        }
        return Response::json("false");
    }

    public function delete($id)
    {
        if (!userCan('revenues_delete')) {
            return Response::json("false");
        }
        $revenue = Revenues::find($id);
        if ($revenue->delete()) {
            delete_folder('uploads/revenues/'.$id);
            return Response::json($id);
        }
        return Response::json("false");
    }
}
