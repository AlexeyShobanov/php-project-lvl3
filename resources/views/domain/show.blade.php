<html>
    <head>
        <meta charset="UTF-8">
        <title>Laravel</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container">
            @include('flash::message')
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('domains.index') }}">Domains</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container mt-3">
            <h1 class="mb-5">{{$domain->name}}</h1>
            <table class="table">
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

            <h2 class="mb-3">Checks</h2>
             @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            {{ Form::open(['url' => route('domains.checks.store', $domain)]) }}
                {{ Form::submit('Run check') }}
            {{ Form::close() }}

            <table class="table">
                @foreach($domain->checks as $check)
                <tr>
                    <td>{{$check->status_code}}</td>
                    <td>{{$check->updated_at}}</td>
                </tr>
                @endforeach
            </table>

        </div>

        <script src="//code.jquery.com/jquery.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <script>
            $('#flash-overlay-modal').modal();
        </script>

    </body>
</html>