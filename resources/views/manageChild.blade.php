<ul>

@foreach($childs  as $child)

	<li>
		@if(count($child->childs) == 0 )

	
		<i class="fa fa-plus"> </i>  

		@else
		<i class="fa fa-minus"> </i>  
		@endif
		{{ $child->name}}
	
	@if(count($child->childs))

        @include('manageChild',['childs' => $child->childs])
		  

        @endif

	</li>

@endforeach

</ul>


