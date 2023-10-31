
<div class="modal fade" id="positionCodeModal" tabindex="-1" role="dialog" aria-labelledby="positionCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="positionCodeModalLabel">Position Code</h4>
        </div>
        <div class="modal-body">
            <table id="myTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>አሁን የስራ መደቡን የያዘዉ ሰራትኛ</th>
                            <th>የስራ መደቡ መለያ</th>
                          
                            <th>የስራ መደብ </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($positionCodes as $positionCode)
                            <tr>
                          
                              
                                    <td> {{ $loop->index + 1 }} </td>
                                <td>
                                    <a
                                        href="{{ $positionCode?->employee != null ? route('employee.show', ['id' => $positionCode?->employee?->id]) : '#' }}">{{ $positionCode?->employee?->name ?? '-' }}</a>
                                </td>
                                <td>{{ $positionCode->code }}</td>
                            <td>
                                @if($positionCode->employee_id != null)
                                {{  $positionCode->position->jobTitle->name }}
                                @else
                                {{  '-' }}
                                @endif
                              </td>
                              
                                <td>
                                    <a href="#"
                                        onclick="editEntry('{{ route('position/{position}/position-code.update', ['position' => $crud->entry->id, 'id' => $positionCode->id]) }}','{{ $positionCode->code }}')"
                                        data-toggle="modal" data-target="#position_code_edit" target="_self">
                                        <i class="la la-edit"></i> Edit
                                    </a>
                                    @if ($positionCode->employee == null)
                                        <a href="javascript:void(0)" onclick="deleteEntry(this)"
                                            data-route="{{ route('position/{position}/position-code.destroy', ['position' => $crud->entry?->id, 'id' => $positionCode->id]) }}">
                                            <i class="la la-trash"></i> Delete
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>