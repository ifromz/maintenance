@extends('maintenance::layouts.main')

@section('title', 'Create Stock')

@section('content')

    <div class="col-md-12">

        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">Create Stock</h3>
            </div>
            <div class="panel-body">
                {!!
                    Form::open([
                        'url' => route('maintenance.inventory.stocks.store', [$item->id]),
                        'class' => 'form-horizontal',
                    ])
                !!}

                @include('maintenance::inventory.stocks.form')

                {!! Form::close() !!}
            </div>

        </div>
    </div>
@stop
