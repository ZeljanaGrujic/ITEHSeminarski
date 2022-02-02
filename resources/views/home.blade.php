@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <div class="card">

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div id="app"></div>
                        <h1>Dobrodosli/a, {{ Auth::user()->name }}!</h1>
                        <h4></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
