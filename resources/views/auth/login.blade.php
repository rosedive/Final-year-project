@extends('layouts.auth')

@section('page-title', trans('app.login'))

@section('content')

<div class="col-md-12" id="login">
   <div class="row">
        <div class="col-md-12 bg-white">
            <img src="{{ url('assets/img/rplogo1.png') }}" alt="{{ settings('app_name') }}" height="70" class="mb-5"> 
           <b><p class="text-success text-center" style="color: #0d563f;font-size: 30px;">ONLINE CLEARANCE SYSTEM</p></b>
        </div>
    </div>
    <br>
    
        <div class="row">
            <div class="col-md-6 pull-left" style="margin-left: -30px;">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('auth.staff') }}" class="text-center no-decoration">
                                <div class="icon">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                                <p class="lead">Staff Login</p>
                            </a>
                        </div>
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('auth.student') }}" class="text-center no-decoration">
                                <div class="icon">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                                <p class="lead">Student Login</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10 bg-white" style="margin-left: -360px;font-family: Cooper; font-size: 24px;">
                Welcome to Online Clearance System 
              <br>
              <p class="text text-justify" style="color: black;font-family: Franklin Gothic Book;font-size: 15px;"> Online clearance system is an internet dependent work that can help build an effective information management for IPRC Kigali. It is aimed at developing and designing an online clearance system that replaces the current system of clearance for graduates and terminated staff and can also help graduate to carry out their clearance without coming to the various offices for clearance. The designed system serves as a more reliable and effective means of undertaking student clearance, remove all forms of delay compared to the current system and stress as well as enable you to understand the procedure involved. </p>
            </div>
        </div>
    
</div>
<!-- <div class="jumbotron jumbotron-fluid card" style="background-color:white">
  <div class="container text-center">
    <h1 class="display-4" style="color: #179970;">ONLINE CLEARANCE SYSTEM</h1>

  </div>
</div> -->
@stop

@section('scripts')
@stop