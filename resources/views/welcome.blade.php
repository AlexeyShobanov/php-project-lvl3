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
        
        <div>
            <ul>
                <li>
                    <a href="{{ route('index') }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('domains.index') }}">Domains</a>
                </li>
            </ul>
        </div>

        <h1>Page Analyzer</h1>
        <h3>Check web pages for free</h3>
        <hr>

         @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ Form::open(['url' => route('store')]) }}
            {{ Form::text('name', '', array('placeholder'=>'https://www.example.com')) }}
            {{ Form::submit('Add') }}
        {{ Form::close() }}

        <script src="//code.jquery.com/jquery.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <script>
            $('#flash-overlay-modal').modal();
        </script>

    </body>
</html>
