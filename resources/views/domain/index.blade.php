@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Domains</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <th class='text-center'>ID</th>
                    <th>Name</th>
                    <th class='text-center'>Сheck date</th>
                    <th class='text-center'>Status code</th>
                </tr>
                @foreach($domains as $domain)
                    <tr>
                        
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection