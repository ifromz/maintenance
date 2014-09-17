@extends('maintenance::layouts.public')

@section('content')
<div class="form-box" id="login-box">
    
    <div class="header">{{ $title }}</div>
    
    <form action="../../index.html" method="post">
        <div class="body bg-gray">
            <h4>Registration:</h4>
            <p>
                Registering allows you to:
                
                <ul>
                    <li>View your current and past work orders</li>
                    <li>Edit or Update your work orders with more information and images</li>
                    <li>Check the current status and what's been done</li>
                    <li>Easily create more work orders when needed</li>
                </ul>
            
                All you have to do is enter in your <b>name, email and password</b> and you're all set.

            </p>

        </div>
        
        <div class="footer">
             <p class="text-center">
                <a class="btn bg-olive btn-block" href="{{ route('maintenance.register') }}">Take me to the registration page</a>
            </p>
        </div>
        
    </form>
    
</div>
@stop