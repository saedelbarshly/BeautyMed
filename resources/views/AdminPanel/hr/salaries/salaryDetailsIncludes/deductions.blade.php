<div class="modal fade text-md-start" id="{{$deductionType}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-50">
                <div class="table-responsive">
                    <table class="table table-bordered mb-2">
                        <thead class="table-dark">
                            <tr>
                                <th>التاريخ</th>
                                <th>المبلغ</th>
                                <th>البيان</th>
                                <th>مسؤل التنفيذ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $thisDeductions = App\Models\SalariesDeductions::where('EmployeeID',$user['id'])
                                                                    ->where('Status','Done')
                                                                    ->where('month',$month)
                                                                    ->where('year',$year)
                                                                    ->where('Type',$deductionType)->get();
                            ?>

                            @foreach($thisDeductions as $thisDeduction)
                                <tr id="row_{{ $thisDeduction->id }}">
                                    <td>
                                        {{ $thisDeduction->DeductionDate }}
                                    </td>
                                    <td class="text-center">
                                        {{ $thisDeduction->Deduction }}
                                        @if(userCan('deductions_delete'))
                                            <div class="clearfix"></div>
                                            <a class="btn btn-xs btn-danger" href="{{route('admin.deductions.delete',$thisDeduction['id'])}}">
                                                حذف
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $thisDeduction->Reason }}
                                    </td>
                                    <td>{{$thisDeduction->responsible->name ?? '-'}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
