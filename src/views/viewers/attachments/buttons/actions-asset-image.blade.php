@extends('maintenance::layouts.buttons.dropdown')

@section('dropdown.body.content')
    <li>
        <a href="{{ route('maintenance.assets.images.show', array($asset->id, $image->id)) }}">
            <i class="fa fa-search"></i> View Image
        </a>
    </li>
    <li>
        <a href="{{ route('maintenance.assets.images.destroy', array($asset->id, $image->id)) }}" data-method="delete"
           data-message="Are you sure you want to delete this image?">
            <i class="fa fa-trash-o"></i> Delete Image
        </a>
    </li>
@overwrite
