<html>
    <head>
        <meta charset="UTF-8">
        <title>Laravel</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>

    <body>
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
        <h1>Domains</h1>

        <table class="table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Сheck date</th>
            </tr>
            @foreach($domains as $domain)
                <tr>
                    <td>{{ $domain->id }}</td>
                    <td><a href="{{ route('domains.show', $domain->id) }}">{{ $domain->name }}</a></td>
                    <td>{{ \DB::table('domain_checks')->where('domain_id', $domain->id)->max('updated_at') }}</td>
                </tr>
            @endforeach
        <script src="//code.jquery.com/jquery.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <script>
            $('#flash-overlay-modal').modal();
        </script>

    </body>
</html>