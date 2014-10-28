@extends('maintenance::layouts.public')

@section('content')

<div class="form-box" id="login-box">
    
    <div class="header">{{ $title }}</div>
    
    {{ Form::open(array('url'=>route('maintenance.register'), 'class'=>'ajax-form-post clear-form', 'data-status-target'=>'#maintenance-register-status')) }}
    
        <div class="body bg-gray">
            @if (Session::has('message'))
                <div class="status-message alert alert-{{ Session::get('messageType') }}">
                    {{ Session::get('message') }}
                </div>
            @endif

            <div id="maintenance-register-status">
                
            </div>
            
            <div class="form-group">
                {{ Form::text('first_name', NULL, array('class'=>'form-control', 'placeholder'=>'First Name')) }}
            </div>
            <div class="form-group">
                {{ Form::text('last_name', NULL, array('class'=>'form-control', 'placeholder'=>'Last Name')) }}
            </div>
            <div class="form-group">
                {{ Form::text('email', NULL, array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
            </div>
            <div class="form-group">
                {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
            </div>
            <div class="form-group">
                {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
            </div>
            
            <div class="alert alert-info">
                <p>For the Captcha field, enter the letters you see in the picture below.</p>
            </div>
            
            <div class="form-group col-md-6">
                <img class="responsive" src="{{ Captcha::img() }}">
            </div>
            
            <div class="form-group col-md-6">
                {{ Form::text('captcha', NULL, array('class'=>'form-control', 'placeholder'=>'Captcha')) }}
            </div>
            
            <div class="clearfix"></div>
            
        </div>
    
        <div class="footer">                    
            <button type="submit" class="btn bg-olive btn-block">Register</button>

            <p class="text-center">
                <a href="{{ route('maintenance.login') }}" class="text-center">I already have an account</a>
            </p>
            
            <p class="text-center">
                <a href="{{ route('maintenance.register.why') }}" class="text-center">Why do I have to register?</a>
            </p>
        </div>
    
    {{ Form::close() }}
    
</div>
@stop