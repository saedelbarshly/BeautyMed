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
                                <th class="text-center">#</th>
                                <th class="text-center">{{trans('common.name')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($refferalClients as $refferalClient)
                            <tr id="row_{{$refferalClient->id}}">
                                <td>
                                    {{$refferalClient['id']}}
                                </td>
                                <td>
                                    {{$refferalClient['name']}}
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="javascript:;" data-bs-target="#editrefferalClient{{$refferalClient->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>
                                    <?php $delete = route('admin.refferalClients.delete',$refferalClient->id); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$refferalClient->id}}')">
                                        <i data-feather='trash-2'></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-3 text-center ">
                                        <h2>{{trans('common.nothingToView')}}</h2>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $refferalClients->links('vendor.pagination.default') }}


            </div>
        </div>
    </div>
    <!-- Bordered table end -->

@foreach($refferalClients as $refferalClient)

    <div class="modal fade text-md-start" id="editrefferalClient{{$refferalClient->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}: {{$refferalClient['name']}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.refferalClients.update',$refferalClient->id), 'id'=>'editrefferalClientForm'.$refferalClient->id, 'class'=>'row gy-1 pt-75 justify-content-center'])}}
                       
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name',$refferalClient->name,['id'=>'name', 'class'=>'form-control'])}}
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
    <a href="javascript:;" data-bs-target="#createrefferalClient" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.CreateNew')}}
    </a>

    <div class="modal fade text-md-start" id="createrefferalClient" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                    </div>
                    {{Form::open(['url'=>route('admin.refferalClients.store'), 'id'=>'createrefferalClientForm', 'class'=>'row gy-1 pt-75 justify-content-center'])}}
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name">{{trans('common.name')}}</label>
                            {{Form::text('name','',['id'=>'name', 'class'=>'form-control'])}}
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


<script src="{{asset('AdminAssets/app-assets/js/scripts/pages/modal-add-service.js')}}"></script>
@stop
<style>

</style>