<div class="modal fade text-md-start" id="addComplaint{{isset($client) ? $client->id : ''}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content"> 
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50"> 
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.addComplaint')}}</h1>
                        @if(isset($client))
                             <p>{{$client->name}}</p>                           
                        @endif
                </div>
                {{Form::open(['url'=>route('admin.complaints.store'), 'id'=>'addComplaintForm', 'class'=>'row gy-1 pt-75'])}}
                      
                   
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="user_id">{{trans('common.clients')}}</label>
                        {{Form::select('client_id',clientList(),'',['id'=>'client_id','class'=>'form-select selectpicker','data-live-search'=>'true'])}}
                    </div>
                        
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="client_id">{{trans('common.creatorUser')}}</label>
                        {{Form::select('creator_user_id',usersList(),'',['id'=>'client_id','class'=>'form-select selectpicker','data-live-search'=>'true'])}}
                    </div> 

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="client_id">{{trans('common.assignedUser')}}</label>
                        {{Form::select('assigned_user_id',usersList(),'',['id'=>'client_id','class'=>'form-select selectpicker','data-live-search'=>'true'])}}
                    </div> 

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="day">{{trans('common.date')}}</label>
                        {{Form::date('date','',['id'=>'day', 'class'=>'form-control','required'])}}
                    </div>  

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="client_id">{{trans('common.status')}}</label>
                        {{Form::select('status',complaintsStatus(session()->get('Lang')),'',['id'=>'client_id','class'=>'form-select'])}}
                    </div> 
                    
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="reason">{{trans('common.details')}}</label>
                        {{Form::textarea('details','',['id'=>'reason', 'class'=>'form-control','rows'=>'3'])}}
                    </div>

                    <div class="col-12 col-md-12">
                        <label class="form-label" for="reason">{{trans('common.response')}}</label>
                        {{Form::textarea('response','',['id'=>'reason', 'class'=>'form-control','rows'=>'3'])}}
                    </div>

                   

                                 
                    <div class="col-12 text-center mt-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1">{{trans('common.Save changes')}}</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                            {{trans('common.Cancel')}}
                        </button>
                    </div>


                {{Form::close()}}

    
            </div>
        </div>
    </div>
</div>
