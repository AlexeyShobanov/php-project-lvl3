@extends('layouts.app')

@section('title', 'Domains List')

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
                        <td class='text-center'>{{ $domain->id }}</td>
                        <td><a href="{{ route('domains.show', $domain->id) }}">{{ $domain->name }}</a></td>
                        <td>{{ $lastChecks[$domain->id]->created_at ?? ''}} </td>
                        <td class='text-center'>{{ $lastChecks[$domain->id]->status_code ?? ''}} </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection