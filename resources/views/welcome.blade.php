@extends('layouts.app')

@section('content')
    <div class="container">
        @include('flash::message')
    </div>
    <div class="jumbotron jumbotron-fluid bg-light">
        <div class="container-lg">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-8 mx-auto text-center text-dark">
                    <h1 class="display-3">Page Analyzer</h1>
                    <p class="lead">Check web pages for free</p>
                    {{ Form::open(array_merge(['url' => route('domains.store')], ['class' => 'd-flex justify-content-center'])) }}
                        {{ Form::text('name', $url ?? '', array_merge(['class' => 'form-control form-control-lg'], ['placeholder' => 'https://www.example.com'])) }}
                        {{ Form::submit('Add', ['class' => 'btn btn-lg btn-primary ml-3 px-5 text-uppercase']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection