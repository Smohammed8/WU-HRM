@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [

    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid d-print-none">
        <h2>
            <span class="text-capitalize">ID Card</span>
            <small>new</small>
        </h2>
    </section>
@endsection

@section('content')
<form action="{{ route('signature.store') }}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header"><strong>New ID Card</strong></div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="signature">Signature File</label>
                <input class="form-control form-control-sm" name="signature" id="signature" type="file"/>
              </div>
            </div>
            <div class="col-sm-8">
              <img src="" alt="" id="signature_img" height="100px">
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="seal">Seal File</label>
                <input class="form-control form-control-sm" name="seal" id="seal" type="file"/>
              </div>
            </div>
            <div class="col-sm-8">
              <img src="" alt="" id="seal_img" height="100px"> 
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label for="titter">Titter File</label>
                <input class="form-control form-control-sm" name="titter" id="titter" type="file"/>
              </div>
            </div>
            <div class="col-sm-8">
              <img src="" alt="" id="titter_img" height="100px"> 
            </div>
          </div>
      </div>
    </div>
    <button class="btn btn-success">Submit</button>
    </div>
  </div>
</form>
@endsection


@section('after_styles')
@endsection

@section('after_scripts')
  <script>
    signature.onchange = evt => {
      const [file] = signature.files
      if (file) {
        signature_img.src = URL.createObjectURL(file)
      }
    }

    seal.onchange = evt => {
      const [file] = seal.files
      if (file) {
        seal_img.src = URL.createObjectURL(file)
      }
    }

    titter.onchange = evt => {
      const [file] = titter.files
      if (file) {
        titter_img.src = URL.createObjectURL(file)
      }
    }
  </script>
@endsection
