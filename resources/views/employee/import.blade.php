@extends(backpack_view('blank'))
@section('content')
<form action="/import" method="POST" enctype="multipart/form-data">
@csrf
<input type="file" name="file" id="">
<select name="type" id="">
    <option value="country">Country</option>
    <option value="employee">Employee</option>
    <option value="region">Region</option>
</select>
<select name="college" id="">
    @foreach ($colleges as $key=>$college)
        <option value="{{$key}}">{{$college}}</option>
    @endforeach
</select>
<input type="submit" value="Submit">
</form>

@endsection
