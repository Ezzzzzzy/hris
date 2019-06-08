<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
    <div>
        <br>
        <h2>You are invited to join {{$role_name}} team. </h2>
        <h2>Please click on the link below or copy it into the address bar of your browser to confirm your email address: </h2>
        <a href="{{ url('user/verify', $verification_code)}}">Join Now</a>
    </div>
</body>
</html>