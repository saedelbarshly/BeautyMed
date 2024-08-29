@extends('AdminPanel.layouts.master')
@section('content')


    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$title}}</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered mb-2">
                        <thead> 
                            <tr> 
                                <th class="text-center"> # </th>
                                <th class="text-center">{{trans('common.date')}}  </th>
                                <th class="text-center">{{trans('common.clientname')}}</th>
                                <th class="text-center">{{trans('common.phone')}}</th>
                                <th class="text-center">{{trans('common.status')}}</th>
                                <th class="text-center">{{trans('common.details')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>   
                            @forelse($complaints as $complaint)
                            <tr id="row_{{$complaint->id}}">
                                <td>
                                     {{$complaint['id']  }} 
                                </td>
                                <td class="text-center text-nowrap">
                                    {{$complaint['date']  }} 
                                </td>
                                <td>
                                    <a href="{{route('admin.clients.profile',$complaint->client_id)}}" class="btn btn-icon btn-light" data-bs-toggle="tooltip" data-bs-placement="top"">
                                       {{$complaint->client->Name ?? '-'  }} 
                                    </a>  
                                </td>    
                                <td class="text-center text-nowrap">  
                                {{$complaint->client->phone ?? '-'  }} 
                                </td>  
                                <td class="text-center text-nowrap">  
                                {{$complaint->status }} 
                                </td>
                                <td class="text-center text-nowrap">  
                                    {{$complaint['details']  }} 
                                </td>  
                                
                                <td class="text-center text-nowrap">
 
                                    <a href="javascript:;" data-bs-target="#editcomplaint{{$complaint->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info">
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                            <i data-feather='edit'></i>
                                        </span>    
                                    </a>

                                    <?php $delete = route('admin.complaints.delete',$complaint->id); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$complaint->id}}')">
                                        <i data-feather='trash-2'></i>
                                    </button>
              
                                </td>
                            </tr> 
                            @empty
                                <tr>
                                    <td colspan="6" class="p-3 text-center ">
                                        <h2>{{trans('common.nothingToView')}}</h2>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $complaints->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->

@foreach($complaints as $complaint)

    <div class="modal fade text-md-start" id="editcomplaint{{$complaint->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                   
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}: {{trans('common.complaint')}} </h1>
                    </div>
                    {{Form::open(['url'=>route('admin.complaints.update',$complaint->id), 'id'=>'editcomplaintForm'.$complaint->id, 'class'=>'row gy-1 pt-75 justify-content-center'])}}
                            
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="user_id">{{trans('common.clients')}}</label>
                        {{Form::select('client_id',clientList(),$complaint->client_id,['id'=>'client_id','class'=>'form-select selectpicker','data-live-search'=>'true'])}}
                    </div>
                       
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="client_id">{{trans('common.creatorUser')}}</label>
                        {{Form::select('creator_user_id',usersList(),$complaint->creator_user_id,['id'=>'client_id','class'=>'form-select selectpicker','data-live-search'=>'true'])}}
                    </div> 

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="client_id">{{trans('common.assignedUser')}}</label>
                        {{Form::select('assigned_user_id',usersList(),$complaint->assigned_user_id,['id'=>'client_id','class'=>'form-select selectpicker','data-live-search'=>'true'])}}
                    </div> 

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="day">{{trans('common.date')}}</label>
                        {{Form::date('date',$complaint->date,['id'=>'day', 'class'=>'form-control','required'])}}
                    </div>  

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="client_id">{{trans('common.status')}}</label>
                        {{Form::select('status',complaintsStatus(session()->get('Lang')),$complaint->status,['id'=>'client_id','class'=>'form-select'])}}
                    </div> 
                    
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="reason">{{trans('common.details')}}</label>
                        {{Form::textarea('details',$complaint->details,['id'=>'reason', 'class'=>'form-control','rows'=>'3'])}}
                    </div>

                    <div class="col-12 col-md-12">
                        <label class="form-label" for="reason">{{trans('common.response')}}</label>
                        {{Form::textarea('response',$complaint->response,['id'=>'reason', 'class'=>'form-control','rows'=>'3'])}}
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
    
    
@endforeach
 
@stop 
    
@section('page_buttons')
 
 
    <!-- create complaint  -->
    <a href="javascript:;" data-bs-target="#addComplaint" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.addComplaint')}}
    </a>

    @include('AdminPanel.clients.createComplaint')
 

@stop


@section('scripts')



<script type="text/javascript">
    $(document).ready(function() {

        var max_fields          = 50;
        var wrapper             = $(".repeatableServices");
        var add_button          = $(".add_Service");
        var wrapperNew             = $(".repeatableNewServices");
        var add_buttonNew          = $(".add_NewService");
        var RepeatOpponentTPL   = $("#RepeatServiceTPL").html();

        var x = 1;
        $(add_button).click(function(e){
            e.preventDefault();
            if(x < max_fields){
                x++;
                $(wrapper).append(RepeatOpponentTPL); //add input box
            }else{
                alert('You Reached the limits')
            }
        });
        $(add_buttonNew).click(function(e){
            e.preventDefault();
            if(x < max_fields){
                x++;
                $(wrapperNew).append(RepeatOpponentTPL); //add input box
            }else{
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click",".delete", function(e){
            e.preventDefault(); $(this).closest('.More').remove(); x--;
        });
        
        $(wrapperNew).on("click",".delete", function(e){
            e.preventDefault(); $(this).closest('.More').remove(); x--;
        });

    });


    let discountRate = document.querySelectorAll('.discountRate1')
    let discountAmount = document.querySelectorAll('.discountAmount1')

    console.log(discountRate)

    discountRate.forEach((el)=>{
        el.addEventListener('focus', ()=>{
            discountRate.forEach((e)=>{
                e.parentElement.style.display="none"
            }) 
        })
    })
    

</script>

@stop

