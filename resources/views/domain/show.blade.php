@extends('layouts.app')

@section('title', 'Domain Name')

@section('content')
    <div class="container-lg">
        <h1 class="mt-5 mb-3">{{$domain->name}}</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <td>id</td>
                    <td>{{$domain->id}}</td>
                </tr>
                <tr>
                    <td>name</td>
                    <td>{{$domain->name}}</td>
                </tr>        
                <tr>
                    <td>created_at</td>
                    <td>{{$domain->created_at}}</td>
                </tr>
                <tr>
                    <td>updated_at</td>
                    <td>{{$domain->updated_at}}</td>
                </tr>
            </table>
        </div>
        <h2 class="mt-5 mb-3">Checks</h2>
        {{ Form::open(['url' => route('domains.checks.store', $domain)]) }}
            {{ Form::submit('Run check', ['class' => 'btn btn-lg btn-primary text-uppercase']) }}
        {{ Form::close() }}
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <td>Time</td>
                    <td>Status</td>
                    <td>H1</td>
                    <td>Description</td>
                    <td>Keywords</td>
                </tr>
                @foreach($domain->checks as $check)
                    <tr>
                        <td>{{$check->updated_at}}</td>
                        <td>{{$check->status_code}}</td>
                        <td>{{$check->h1}}</td>
                        <td>{{$check->description}}</td>
                        <td>{{$check->keywords}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection