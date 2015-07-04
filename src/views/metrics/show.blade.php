@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Viewing Metric')

@section('panel.head.content')
Viewing Metric
@stop

@section('panel.body.content')

    <table class="table">
        <tbody>
            <tr>
                <th>Created By</th>
                <td>{{ $metric->user->full_name }}</td>
            </tr>
        </tbody>
    </table>

@stop