<button type="button" data-backdrop="false" data-toggle="modal" data-target="#addMark" target="_top"
    class="btn  btn-sm btn-outline-primary"><i class="la  la-plus"></i> {{ $candidate->mark!=null?'Update Mark':'Add Mark' }}
</button>
<link href="{{ asset('assets/dist/bootstrap4-modal-fullscreen.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/dist/bootstrap4-modal-fullscreen.min.css') }}" rel="stylesheet" type="text/css" />

<div class="modal fade" id="addMark" tabindex="-10000" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Add Mark</h6>
                <div class="row">
                    <button type="button" class="btn btn-sm btn-outline-primary pull-right" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true"> <i class="la la-times"></i></span>
                    </button>
                </div>
            </div>
            <div class="" id="">
                <div class="card card-body">
                    <form action="{{ route('candidate.addMark',['vacancy'=>$candidate->vacancy->id,'candidate'=>$candidate->id]) }}" method="POST">
                        @csrf
                        <div class="form-group col-sm-12 required" element="div"> <label>Mark</label>
                            <input type="text" value="{{ $candidate->mark??'' }}" required name="mark" class="form-control">
                        </div>
                        <input type="submit" value="Add Mark" class="btn btn-outline-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
