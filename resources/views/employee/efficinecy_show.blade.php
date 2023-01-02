<style>

table {
    border-collapse: collapse;
}

    </style>


<div class="modal fade modal-fullscreen" id="efficiency" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">
      <div class="modal-content">
        <div class="modal-header">

           <div class="row">




             <a href="" class="btn  btn-sm btn-outline-primary float-right mr-1">
                <span aria-hidden="true"> <i class="la la-list"></i> Close </span>
            </a>



           <a href="javascript: window.print();" class="btn  btn-sm btn-outline-primary float-right mr-1"><i class="la la-print"></i> Print</a>


           </div>

        </div>




        <div class="modal-body">


            <table width="100%" border="1" class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2" cellspacing="0">
                <thead>
                  <tr style="background-color: lightblue;">

                    <th> #</th>
                    <th> Evalution Criteria</th>
                    <th> Evalution level </th>
                    <th>Recorded by</th>
                    <th>Obtained Mark</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>

                    @foreach ($employeeEvaluations as $employeeEvaluation)
                        <tr >

                            <td> {{$loop->index+1}}  </td>
                            <td >{{  $employeeEvaluation->evalutionCreteria->name }}( {{ $employeeEvaluation->evalutionCreteria->percent }})</td>
                            <td>{{ $employeeEvaluation->evaluationLevel->name }}({{ $employeeEvaluation->evaluationLevel->weight }})</td>
                            <td>{{ '-' }}</td>
                            <td>{{ $employeeEvaluation->evaluationLevel->weight * $employeeEvaluation->evalutionCreteria->percent }} </td>


                            <td>{{ Carbon\Carbon::parse($employeeEvaluation->created_at)->format('d, F Y') }} </td>
                            <td>
                                <a href="" class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>

                            </td>


                        </tr>


                 @endforeach


                          <tr style="text-align:right;">
                            <td colspan="5">
                                <?php $sum = 0 ?>
                                @foreach ($employeeEvaluations as $employeeEvaluation)
                                <?php $sum =  $sum + ($employeeEvaluation->evaluationLevel->weight * $employeeEvaluation->evalutionCreteria->percent); ?>
                                @endforeach
                                  Total point: <span style="border-bottom: 3px  double;">   {{ $sum/4}} %</span>
                            </td>
                            <td colspan="1"></td>
                        </tr>





                </tbody>
              </table>



            {{-- <ul class="pagination">
                {{ $employeeEvaluations->links() }}
            </ul> --}}


        </div>


      </div>
    </div>
  </div>
<!---- //////////////////////////////////////////////////////////// -->




