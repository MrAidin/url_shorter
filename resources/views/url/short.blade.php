<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css\app.css')}}">
    <title>Document</title>
</head>
<body>
<div class="container">

    </div>
    <div class="col-md-8 offset-2">
        <h1 class="mt-5">Short url</h1>
        <form action="{{ url('short') }}" method="post">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="url" placeholder="Enter your url with https://">
            </div>
            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Short Url</button>
            </div>
        </form>
        <br>
        @if(Session::has('message'))
            <div class="alert alert-success">
                {{ Session::get('message') }}
            </div>
        @endif

        <table class="table">
            <tr>
                <th>original_url</th>
                <th>short_url</th>
            </tr>
            @foreach($urls as $url)
                <tr>
                    <td><a href="{{ $url->url }}" target="_blank">{{$url->url}}</a></td>
                    <td><a href="{{ url('/link/'.$url->short_url) }}" target="_blank">127.0.0.1:8000/link/{{$url->short_url}}</a></td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

</body>
</html>
