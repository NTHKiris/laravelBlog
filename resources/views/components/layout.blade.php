<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title ?? 'My app'}}</title>
</head>
<body style="font-family:sans-serif, margin: 2rem">
        <header>
            <h1>{{$title ?? 'Default title'}}</h1>
            <hr>
        </header>
        <main>
            {{$slot}}
        </main>
        <footer>
            <hr>
            <p style="font-size: 0.8rem">my app</p>
        </footer>
</body>
</html>