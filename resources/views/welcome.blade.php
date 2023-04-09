<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SendSMSPhone</title>
</head>
<body>
    <div style="width: 400px; margin: auto; padding: 20px;">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label>Phone</label><br>
            <input type="text" name="phone"><br><br>
            <input type="submit" name="btn">
        </form>    
    </div>
</body>
</html>