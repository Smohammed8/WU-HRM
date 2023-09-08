<ul>

@foreach($childs  as $child)

	<li>

	
		@if($child->subordinate == true)

		&nbsp;	&nbsp;	
		@else

		@endif

		@if(count($child->childs) == 0 )

		<i class="fa fa-minus"> </i> 

		@else
		<i class="fa fa-plus"> </i>  
		@endif
		{{ $child->name}}  <br> 
	
	   @if(count($child->childs))

        @include('manageChild',['childs' => $child->childs])

		@foreach($child->positions as $position)

		@if(count($child->positions )) &nbsp;&nbsp;&nbsp;	
		<i class="la la-caret-right"> </i> 
		{{$position->name}}-

		@foreach($position->positionCodes as $positionCode)
		
		{{$positionCode->code }}-[ {{ ucfirst($positionCode->employee->name?? '-') }} ]



		<br> 
		@endforeach

		@endif 
		@endforeach

        @endif

	</li>

@endforeach

</ul>


