@extends('maintenance::layouts.buttons.dropdown')

@section('dropdown.body.content')
    <li>
        <a href="{{ $manual->manual_link }}">
            <i class="fa fa-search"></i> View Manual
        </a>
    </li>
    <li>
        <a href="{{ route('maintenance.assets.manuals.destroy', array($asset->id, $manual->id)) }}" data-method="delete"
           data-message="Are you sure you want to delete this manual?">
            <i class="fa fa-trash-o"></i> Delete Manual
        </a>
    </li>
@overwrite