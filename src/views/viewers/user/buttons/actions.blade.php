@extends('maintenance::layouts.buttons.dropdown')

@section('dropdown.body.content')
    <li>
        <a href="{{ route('maintenance.admin.users.show', array($user->id)) }}">
            <i class="fa fa-search"></i> View User
        </a>
    </li>
    <li>
        <a href="{{ route('maintenance.admin.users.edit', array($user->id)) }}">
            <i class="fa fa-edit"></i> Edit User
        </a>
    </li>
    @if(!Sentry::getUser()->id === $user->id)
    <li>
        <a href="{{ route('maintenance.admin.users.destroy', array($user->id)) }}"
           data-method="delete"
           data-message="Are you sure you want to delete this user?">
            <i class="fa fa-trash-o"></i> Delete User
        </a>
    </li>
    @endif
@overwrite