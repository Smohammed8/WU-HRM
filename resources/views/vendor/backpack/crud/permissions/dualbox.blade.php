  @extends('backpack::layout')

   @section('content')
       <div class="container-fluid">
           <div class="row">
               <div class="col-md-6">
                   <select id="permissions-select" multiple>
                       @foreach ($permissions as $permission)
                           <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                       @endforeach
                   </select>
               </div>
               <div class="col-md-6">
                   <select id="selected-permissions" name="permissions[]" multiple>
                       @foreach ($selectedPermissions as $permission)
                           <option value="{{ $permission->id }}" selected>{{ $permission->name }}</option>
                       @endforeach
                   </select>
               </div>
           </div>
       </div>
   @endsection

   @push('after_scripts')
       <script>
           $(document).ready(function() {
               $('#permissions-select').select2();
               $('#selected-permissions').select2();
           });
       </script>
   @endpush
