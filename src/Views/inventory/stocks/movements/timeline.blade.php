@extends('maintenance::layouts.main')

@section('content')

    <div class="col-md-12">

        @if($stock->movements->count() > 0)
            <ul class="timeline">
                @foreach($stock->movements as $movement)

                    <li>

                        @if($movement->before > $movement->after)
                            <i class="fa fa-minus bg-red"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> {{ $movement->created_at }}</span>

                                <h3 class="timeline-header"><a href="#">{{ $movement->reason }}</a></h3>

                                <div class="timeline-body">
                                    <p>{{ $movement->change }} were Removed</p>

                                    <p>Cost: ${{ $movement->cost }}</p>
                                </div>
                            </div>
                        @else
                            <i class="fa fa-plus bg-green"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> {{ $movement->created_at }}</span>

                                <h3 class="timeline-header"><a href="#">{{ $movement->reason }}</a></h3>

                                <div class="timeline-body">
                                    <p>{{ $movement->change }} were Added</p>

                                    <p>Cost: ${{ $movement->cost }}</p>
                                </div>
                            </div>
                        @endif

                    </li>

                @endforeach

                <li class="time-label">
            <span class="bg-gray">
                Stock Created: {{ $stock->created_at }}
            </span>
                </li>
                <li>
                    <i class="fa fa-clock-o"></i>
                </li>
            </ul>
        @endif
    </div>
@stop
