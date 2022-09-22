<!-- Full screen modal -->

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalFullscreen">Full screen</button>


<div class="modal-dialog modal-fullscreen-sm-down">

<div class="row">
    <h5>Employee Efficiency </h5>
    <div class=" no-padding no-border">
        <div class="">
            <a href="{{ route('{employee}/employee-language.create',['employee'=>$crud->entry->id]) }}" class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i class="la la-plus"></i> {{ trans('backpack::crud.add') }} {{ 'Employee Langauge'}}</span></a>
        </div>
        <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs mt-2" cellspacing="0">
            <thead>
              <tr>
                <th>Langauge</th>
                <th>Speaking</th>
                <th>Reading</th>
                <th>Writing</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($employeeLanguages as $employeeLanguage)
                    <tr>
                        <td>{{ $employeeLanguage->language->name }}</td>
                        <td>{{ $employeeLanguage->speaking }}</td>
                        <td>{{ $employeeLanguage->reading }}</td>
                        <td>{{ $employeeLanguage->writing }}</td>
                        <td>
                            <a href="{{ route('{employee}/employee-language.edit', ['employee'=>$crud->entry->id,'id'=>$employeeLanguage->id]) }}" class="btn btn-sm btn-link"><i class="la la-edit"></i> Edit</a>
                            <a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="{{ route('{employee}/employee-language.destroy', ['employee'=>$crud->entry->id,'id'=>$employeeLanguage->id]) }}" class="btn btn-sm btn-link" data-button-type="delete"><i class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                        </td>
                    </tr>
                @endforeach
                @if(count($employeeLanguages)==0)
                    <tr>
                        <td colspan="5" class="text-center">No Employee Language</td>
                    </tr>
                @endif
            </tbody>
          </table>
          <div>
            {{ $employeeLanguages->links() }}
          </div>
    </div>
</div>

</div>
