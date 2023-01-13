@props(['children'])
<ul>
    @foreach ($children as $child)
        <li>
            <a href="javascript:void(0);">
                <fieldset>
                    <div class="card-custom bg-success-o-40 rounded-lg">
                        <div class="card-body justify-content-start pl-2" style="overflow-wrap: break-word;">
                            {{-- <i class=" fa-university"></i> --}}
                            {{-- <span class="d-block" style="overflow-wrap: break-word;"> <b> {{ $child->name }}</b> </span> --}}
                            <div class="member-details">

                                @if ($child->parent_unit_id == null)
                                   <span title="{{ $child->chairManType->name ?? null }}" class="badge border border-info badge-pill badge-white font-size-h5-d" style="overflow-wrap: break-word; font-size:13px;">
                                    @else
                                    <span title="{{ $child->chairManType->name ?? null }}" class="badge border border-white badge-pill badge-white font-size-h5-d" style="overflow-wrap: break-word; font-size:13px;">
                                    @endif

                                    @if ($child->parent_unit_id == null)
                                        <i class=" la la-flag"></i>
                                    @endif

                                  @if ($child->parent_unit_id == null)
                                      {{ explode('[',$child->name)[0] }}
                                  @else
                            <strong>{{ explode('[',$child->name)[0] }} </strong>
                                  @endif
                                </span>

                            </div>
                        </div>
                    </div>

                </fieldset>

            </a>
            @if ($child->childs->isNotEmpty())
                <x-tree-root :children="$child->childs"></x-tree-root>
            @endif
        </li>
    @endforeach
</ul>
