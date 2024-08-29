<?php

namespace App\Http\Controllers\admin\accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SafesBanks;
use App\Models\Expenses;
use Response;

class ExpensesController extends Controller
{
    public function index()
    {
        //check if authenticated
        if (!userCan('expenses_view') ) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        //select from DB
        $expenses = Expenses::whereNotIn('Type',['transfeerToAnother'])->orderBy('id','desc');

        //if not allowed to view all just return his branch employees
        if (!userCan('expenses_view')) {
            $expenses = $expenses->where('branch_id',auth()->user()->branch_id);
        } else {
            //filter by branch
            if (isset($_GET['branch_id'])) {
                if ($_GET['branch_id'] != 'all') {
                    $expenses = $expenses->where('branch_id',$_GET['branch_id']);
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
            if ($_GET['safe_id'] != '' ) {
                $expenses = $expenses->where('safe_id',$_GET['safe_id']);
            }
        }

        if (isset($_GET['employee']) ) {
            if ($_GET['employee'] != '' ) {
                $expenses = $expenses->where('UID',$_GET['employee']);
            }
        }

        if (isset($_GET['Type']) ) {
            if ($_GET['Type'] != '' ) {
                $expenses = $expenses->where('Type',$_GET['Type']);
            }
        }


        $expenses = $expenses->where('month',$month)->where('year',$year);
        $expenses = $expenses->get();

        return view('AdminPanel.accounts.expenses.index',[
            'active' => 'expenses',
            'title' => trans('common.expenses'),
            'expenses' => $expenses,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.expenses')
                ]
            ]
        ]);
    }

    public function store(Request $request)
    {
        if (!userCan('expenses_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }

        //check if user assigned to branch
        if (auth()->user()->branch == '') {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAssgnedToAnyBranchPleaseContactAdmin'));
        }
        $data = $request->except(['_token','Attachments']);
        $data['month'] = date('m',strtotime($request['ExpenseDate']));
        $data['year'] = date('Y',strtotime($request['ExpenseDate']));
        $data['UID'] = auth()->user()->id;

        $safe = SafesBanks::find($request['safe_id']);
        $data['branch_id'] = $safe->branch_id;

        $expense = Expenses::create($data);

        if ($request->Attachments != '') {
            $Files = [];
            if ($request->hasFile('Attachments')) {
                foreach ($request->Attachments as $file) {
                    $Files[] = upload_image_without_resize('expenses/'.$expense->id , $file );
                }
                $expense['Attachments'] = base64_encode(serialize($Files));
                $expense->update();
            }
        }
        if ($expense) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function update(Request $request, $id)
    {
        if (!userCan('expenses_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $expense = Expenses::find($id);
        $data = $request->except(['_token','Attachments']);
        $data['month'] = date('m',strtotime($request['ExpenseDate']));
        $data['year'] = date('Y',strtotime($request['ExpenseDate']));
        $data['UID'] = auth()->user()->id;

        $safe = SafesBanks::find($request['safe_id']);
        $data['branch_id'] = $safe->branch_id;

        if ($request->Attachments != '') {
            if ($expense->Attachments != '') {
                $Files = unserialize(base64_decode($expense->Attachments));
            } else {
                $Files = [];
            }
            if ($request->hasFile('Attachments')) {
                foreach ($request->Attachments as $file) {
                    $Files[] = upload_image_without_resize('expenses/'.$id , $file );
                }
                $data['Attachments'] = base64_encode(serialize($Files));
            }
        }

        $update = Expenses::find($id)->update($data);
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
        if (!userCan('expenses_delete_photo')) {
            return Response::json("false");
        }
        $expense = Expenses::find($id);
        $Files = [];
        if ($expense->Attachments != '') {
            $Files = unserialize(base64_decode($expense->Attachments));
        }
        if (in_array($photo,$Files)) {
            delete_image('uploads/expenses/'.$id , $photo);
            if (($key = array_search($photo, $Files)) !== false) {
                unset($Files[$key]);
            }
            $expense['Attachments'] = base64_encode(serialize($Files));
            $expense->update();
            return Response::json('photo_'.$X);
        }
        return Response::json("false");
    }

    public function delete($id)
    {
        if (!userCan('expenses_delete')) {
            return Response::json("false");
        }
        $expense = Expenses::find($id);
        if ($expense->delete()) {
            delete_folder('uploads/expenses/'.$id);
            return Response::json($id);
        }
        return Response::json("false");
    }

}
