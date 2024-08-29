<?php

namespace App\Http\Controllers\admin\ClientsFollowUps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Clients\CreateClient;
use App\Http\Requests\Clients\EditClient;
use App\Models\Clients;
use App\Models\User;
use App\Models\Offer;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\SafesBanks;
use App\Models\Expenses;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public function index()
    {
        if (!userCan('clients_view') ) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $clients = Clients::orderBy('code','asc');
        $services = Service::orderBy('id','desc')->select('name','id')->get();
        $offers = Offer::orderBy('id','desc')->select('name','id')->get();



        //filter by name
        if (isset($_GET['Name'])) {
            if ($_GET['Name'] != '') {
                $clients = $clients->where('Name','like','%'.$_GET['Name'].'%');
            }
        }
        //filter by phone
        if (isset($_GET['phone'])) {
            if ($_GET['phone'] != '') {
                $clients = $clients->where('phone',$_GET['phone']);
            }
        }

        if (isset($_GET['code'])) {
            if ($_GET['code'] != '') {
                $clients = $clients->where('code',$_GET['code']);
            }
        }

        if (isset($_GET['status'])) {
            if ($_GET['status'] != '') {
                $clients = $clients->where('status',$_GET['status']);
            }
        } else {
            $clients = $clients->where('status','Active');
        }


        //filter by whatsapp
        if (isset($_GET['whatsapp'])) {
            if ($_GET['whatsapp'] != '') {
                $clients = $clients->where('whatsapp',$_GET['whatsapp']);
            }
        }

        //filter by refferal_id
        if (isset($_GET['refferal_id'])) {
            if ($_GET['refferal_id'] != '' && $_GET['refferal_id'] != 0) {
                $clients = $clients->where('refferal_id',$_GET['refferal_id']);
            }
        }

        if (isset($_GET['from_date'])) {
            if ($_GET['from_date'] != '') {
                $clients = $clients->where('dateStr','>=',strtotime($_GET['from_date']));
            }
        }
        if (isset($_GET['to_date'])) {
            if ($_GET['to_date'] != '') {
                $clients = $clients->where('dateStr','<=',strtotime($_GET['to_date']));
            }
        }
        $clients = $clients->paginate(25);
        return view('AdminPanel.clients.index',[
            'active' => 'clients',
            'title' => trans('common.clients'),
            'clients' => $clients,
            'services' => $services,
            'offers' => $offers,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.clients')
                ]
            ]
        ]);
    }

    public function noAgentClients()
    {
        if (!userCan('clients_view') && !userCan('clients_view_no_agent')) {
            return redirect()->route('admin.index')
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $clients = Clients::orderBy('id','desc')->where('UID','0');
        //if not allowed to view all just return his client employees
        if (!userCan('clients_view')) {
            if (!userCan('clients_view_branch')) {
            } else {
                $clients = $clients->where('branch_id',auth()->user()->branch_id);
            }
        }
        //filter by agent
        if (isset($_GET['class'])) {
            if ($_GET['class'] != 'all') {
                $clients = $clients->where('clientClass',$_GET['class']);
            }
        }
        //filter by name
        if (isset($_GET['Name'])) {
            if ($_GET['Name'] != '') {
                $clients = $clients->where('Name','like','%'.$_GET['Name'].'%');
            }
        }
        //filter by phone
        if (isset($_GET['phone'])) {
            if ($_GET['phone'] != '') {
                $clients = $clients->where('phone',$_GET['phone']);
            }
        }
        //filter by cellphone
        if (isset($_GET['cellphone'])) {
            if ($_GET['cellphone'] != '') {
                $clients = $clients->where('cellphone',$_GET['cellphone']);
            }
        }
        //filter by whatsapp
        if (isset($_GET['whatsapp'])) {
            if ($_GET['whatsapp'] != '') {
                $clients = $clients->where('whatsapp',$_GET['whatsapp']);
            }
        }
        $clients = $clients->paginate(25);
        return view('AdminPanel.clients.noAgentClients',[
            'active' => 'noAgentClients',
            'title' => trans('common.noAgentClients'),
            'clients' => $clients,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.noAgentClients')
                ]
            ]
        ]);
    }

    public function changeAgent(Request $request)
    {
        $this->validate($request, [
            'clients' => 'required'
        ]);
        foreach ($request['clients'] as $key => $client) {
            $update = Clients::find($client)->update([
                'UID' => $request['AgentID']
            ]);
        }
        return redirect()->back()
                        ->with('success',trans('common.successMessageText'));
    }


    public function store(CreateClient $request)
    {

        if (!userCan('clients_create')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
                            }

        $clients = Clients::all()->count();
        $lastClient = DB::table('clients')->latest()->first();


        $data = $request->except(['_token']);
        $data['UID'] = auth()->user()->id;

        $client = Clients::create($data);


        $client->dateStr= strtotime($client->date);
        $client->save();

        // if($clients <= 0)
        // {
        //     $client->code = getSettingValue('clientCode')+1;
        //     $client->save();
        // }
        // else
        // {
        //     $client->code = $lastClient->code+1;
        //     $client->save();
        // }

        if ($client) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function storeExcelClient(Request $request)
    {
        $this->validate($request, [
            'excel' => 'required'
        ]);
        $branch_id = auth()->user()->branch_id;
        $user_id = auth()->user()->id;
        if (isset($request->branch_id)) {
            if ($request->branch_id != 'all') {
                $branch_id = $request->branch_id;
            }
        }
        if (isset($request->user_id)) {
            $user_id = $request->user_id;
        }
        Excel::import(new ClientsImport($branch_id,$user_id), request()->excel('File'));

        $request->session()->put('PopSuccess', trans('Site.SavedSuccessfully'));
        return back();
    }

    public function blockAction($id,$action)
    {

        if (!userCan('clients_block')) {
            return redirect()->route('admin.index')
                                ->with('PopError',trans('common.youAreNotAuthorized'));
        }

        $update = Clients::find($id)->update([
            'status' => $action == '1' ? 'Archive' : 'Active'
        ]);
        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }



    public function update(EditClient $request, $id)
    {
        if (!userCan('clients_edit')) {
            return redirect()->back()
                                ->with('faild',trans('common.youAreNotAuthorized'));
        }
        $data = $request->except(['_token']);

        $update = Clients::find($id)->update($data);
        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }


    public function cashBack(Request $request, $client_id)
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
        $data = $request->except(['_token','Attachments','money']);
        $data['ExpenseDate'] = date('Y-m-d');
        $data['month'] = date('m',strtotime($data['ExpenseDate']));  
        $data['year'] = date('Y',strtotime($data['ExpenseDate']));
        $data['Expense'] = $request['money'];
        // $data['puls'] = $request['puls'];
        $data['client_id'] = $client_id;
        $data['Type'] = 'client_cash_back';
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

    public function delete($id)
    {
        if (!userCan('clients_delete')) {
            return Response::json("false");
        }
        $client = Clients::find($id);
        if ($client->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}
