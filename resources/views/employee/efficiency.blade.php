<!-- //////////////////////// Eficieny Modal  ///////////////////////////// -->
<link href="{{ asset('assets/dist/bootstrap4-modal-fullscreen.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/dist/bootstrap4-modal-fullscreen.min.css') }}" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/calendar/css/redmond.calendars.picker.css') }}" />

<div class="modal fade modal-fullscreen" id="efficiency" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel"> Employee: {{ $crud?->entry?->name }} &nbsp; &nbsp;
                    &nbsp;
                    Working Unit: {{ $crud?->entry?->position->unit?->name }} &nbsp; &nbsp;<br> Last Efficiency :{{ $crud?->entry?->evaluations[0]->total_mark }}  &nbsp; &nbsp; Job
                    Position : {{ $crud?->entry?->position?->name }} </h6>
                <div class="row">
                    @canany(['employee.efficency.icrud', 'employee.efficency.create'])
                        <a class="btn  btn-sm btn-outline-primary float-right mr-1" data-toggle="collapse"
                            href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <span aria-hidden="true"> <i class="la la-plus"></i> Add new </span>
                        </a>
                    @endcanany
                    <button type="button" class="btn  btn-sm btn-outline-primary pull-right mr-1" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true"> <i class="la la-times"></i> Close </span>
                    </button>
                </div>
            </div>
            <!-------- //////////////////////////// -->
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <!--- ////////////////////// Evalution form ----------->
                    <form action="{{ route('employeeEvaluation.create', []) }}" method="GET">
                        @csrf

                        <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fiscal quarter:&nbsp;&nbsp;&nbsp;
                            <select name="quarter" id="quarter"style="width:100%;" class="form-control select2"
                                required="required">
                                <option value="">Select fiscal quater.. </option>
                                @foreach ($quarters as $quarter)
                                    <option value="{{ $quarter->id }}">{{ $quarter->name }}</option>
                                @endforeach
                            </select>
                        </span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="float-right"> Fiscal Year: &nbsp;&nbsp;&nbsp;
                            <select class="form-control select2" style="width:100%;" name="year" required>
                                <option value=""> Select fiscal year.. </option>
                                <option value="2014"> 2014 </option>
                                <option value="2015"> 2015 </option>
                                <option value="2016"> 2016</option>
                                <option value="2017"> 2017</option>
                                <option value="2018"> 2018 </option>
                                <option value="2019"> 2019 </option>
                                <option value="2020"> 2020</option>
                                <option value="2021"> 2021</option>
                            </select>
                        </span>

                        
                        <table class="table table-hover" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr style="background-color: lightblue">
                                    <th>#</th>
                                    <th> Employee Evalution Criteria</th>
                                    <th> Evaluation Levels </th>
                                </tr>
                            </thead>
                            <tbody>
                              
                                <input type="hidden" name="employee" value="{{ $crud->entry->id }}">
                                @foreach ($evalutionCreterias as $evalutionCreteria) 
                                    <tr>

                                        <td> {{ $loop->index + 1 }} </td>

                                        <td>
                                            <input name="criteria[]" type="hidden" value="{{ $evalutionCreteria->id }}" />

                                            {{ $evalutionCreteria->name }} [ {{ $evalutionCreteria->percent }}]
                                        </td>

                                        {{-- <?php //echo dump($evalutionCreteria->id ); ?> --}}


                                        <td>
                                            @if ($style != null)
                                                @if ($style == 'Select Box')
                                                    <select name="level{{ $evalutionCreteria->id }}[]" class="form-control select2" style="width:100%;"  required>
                                                        <option value=""> Select evaluation mark.. </option>
                                                        <option value="4"> Excellent[4] </option>
                                                        <option value="3"> Very Good[3] </option>
                                                        <option value="2"> Good[2] </option>
                                                        <option value="1"> Poor[1] </option>
                                                    </select>
                                                @else
                                                    <input name="level{{ $evalutionCreteria->id }}[]" type="radio" value="4" required /> Excellent(4) &nbsp;
                                                    <input name="level{{ $evalutionCreteria->id }}[]" type="radio" value="3" required /> Very good(3) &nbsp;
                                                    <input name="level{{ $evalutionCreteria->id }}[]" type="radio" value="2" required /> Good(2) &nbsp;
                                                    <input name="level{{ $evalutionCreteria->id }}[]" type="radio" value="1" required /> Poor(1) &nbsp;
                                                @endif
                                            @else
                                                <select name="level{{ $evalutionCreteria->id }}[]" class="form-control select2" style="width:100%;" required>
                                                    <option value=""> Select evaluation mark.. </option>
                                                    <option value="4"> Excellent[4] </option>
                                                    <option value="3"> Very Good[3] </option>
                                                    <option value="2"> Good[2] </option>
                                                    <option value="1"> Poor[1] </option>
                                                </select>
                                            @endif
                                        </td>
                                        
                                    </tr>
                                @endforeach
                                @if (count($employeeEvaluations) == 0)
                                    <tr>
                                        <td colspan="7" class="text-center">No evaluations found! </td>
                                    </tr>
                                @endif
                            </tbody>

                        </table>
                        <button type="submit" name="save" class="btn  btn-sm btn-primary float-right mr-1"> <i
                                class="la la-plus"> </i>Save </button>
                    </form>


                 <ul class="pagination">
                {{ $employeeEvaluations->links() }}
            </ul> 

                </div>
            </div>

            <!-- ///////////////////////////////////////////////--->
            <div class="modal-body">


                <table id="crudTable" class="bg-white table table-sm table-hover nowrap rounded shadow-xs mt-2"
                    cellspacing="0">
                    <thead>
                        <tr style="background-color: lightblue;">

                            <th> #</th>
                            <th>Quarter</th>
                            <th>Obtained point</th>
                            <th>Recorded by</th>
                            <th> Added Date</th>
                            <th>Date range </th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($evaluations as $evaluation)
                            <tr>

                                <td>{{ $loop->index + 1 }} </td>
                                <td>{{ $evaluation->quarter->name }}</td>


                                <td>
                                    <?php $sum = 0; ?>
                                    @foreach ($evaluation->employeeEvaluations as $employeeEvaluation)
                                        <?php $sum = $sum + $employeeEvaluation->evaluationLevel->weight * $employeeEvaluation->evalutionCreteria->percent; ?>
                                    @endforeach
                                    <span style="border-bottom: 3px  double;"> {{ $sum / 4 }} %</span>
                                </td>


                                <td>{{ $evaluation->createdBy->name }}</td>
                                <td>{{ $evaluation->created_at->format('d, F Y') }} </td>
                                <td> From {{ $evaluation->quarter->start_date->format('d, F Y') }} to
                                    {{ $evaluation->quarter->end_date->format('d, F Y') }} </td>
                                <td>

                                    <a target="_new"
                                        href="{{ route('evaluation.evaluation_show', ['evaluation_id' => $evaluation->id]) }}"
                                        class="btn  btn-sm btn-outline-primary float-right mr-1">
                                        <span aria-hidden="true"> <i class="la la-list"></i> Details </span>
                                    </a>




                                    <a href="javascript: window.print();"
                                        class="btn  btn-sm btn-outline-primary float-right mr-1"><i
                                            class="la la-print"></i> Print</a>


                                </td>
                            </tr>
                        @endforeach
                        @if (count($evaluations) == 0)
                            <tr>
                                <td colspan="7" class="text-center">No employee evaluation found</td>
                            </tr>
                        @endif

                        <div class="">
                            <span class="mr-5">Total Evalutions: {{ $evaluations->count() }}</span>
                        </div>

                    </tbody>
                </table>

                {{-- <ul class="pagination">
                {{ $employeeEvaluations->links() }}
            </ul> --}}


            </div>


        </div>
    </div>
</div>
