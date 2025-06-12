<!DOCTYPE html>
<html>
<head>
    <title>Page Expired</title>
</head>
<body>
    <h1>Page Expired</h1>
    <p>Your session has expired. Please log in again.</p>
    {{ $exception->getMessage() }}
    <a href="{{ route('profilehub::login') }}">Login</a>
</body>
</html>