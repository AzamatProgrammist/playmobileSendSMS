<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>sendSMS</title>
</head>
<body>
	<?php 
	$token = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIzNzgsInJvbGUiOiIiLCJkYXRhIjp7ImlkIjoyMzc4LCJuYW1lIjoiSXJpc2FsaXlldiBBemFtYXQgUnVzdGFtIG8nZydsaSIsImVtYWlsIjoiYWlyaXNhbGl5ZXY3NzZAZ21haWwuY29tIiwicm9sZSI6IiIsImFwaV90b2tlbiI6ImV5SjBlWEFpT2lKS1YxUWlMQ0poYkdjaU9pSklVekkxTmlKOS5leUp6ZFdJaU9qSXpOemdzSW5KdmJHVWlPaUlpTENKa1lYUmhJanA3SW1sa0lqb3lNemM0TENKdVlXMWxJam9pU1hKcGMyRnNhWGxsZGlCQmVtRnRZWFFnVW5WemRHRnRJRzhuWnlkc2FTSXNJbVZ0WVdsc0lqb2lZV2x5YVhOaGJHbDVaWFkzTnpaQVoyMWhhV3d1WTI5dElpd2ljbTlzWlNJNklpSXNJbUZ3YVY5MGIydGxiaUk2SW1WNVNqQmxXRUZwVDJsS1MxWXhVV2xNUTBwb1lrZGphVSIsInN0YXR1cyI6ImFjdGl2ZSIsInNtc19hcGlfbG9naW4iOiJlc2tpejIiLCJzbXNfYXBpX3Bhc3N3b3JkIjoiZSQkayF6IiwidXpfcHJpY2UiOjUwLCJ1Y2VsbF9wcmljZSI6MTE1LCJ0ZXN0X3VjZWxsX3ByaWNlIjowLCJiYWxhbmNlIjo0ODAwLCJpc192aXAiOjAsImhvc3QiOiJzZXJ2ZXIxIiwiY3JlYXRlZF9hdCI6IjIwMjMtMDEtMjBUMTI6NDQ6MDIuMDAwMDAwWiIsInVwZGF0ZWRfYXQiOiIyMDIzLTAxLTI0VDE5OjE4OjM2LjAwMDAwMFoiLCJ3aGl0ZWxpc3QiOm51bGx9LCJpYXQiOjE2Nzk5ODkyNTksImV4cCI6MTY4MjU4MTI1OX0.t-yZyZXunv1iMIQVqdJ3GkbpyVS8yy42LTd7PudSMyc";
	 ?>
	<form action="{{ route('sms') }}" method="POST">
		@csrf
		<label>Phone</label>
		<input type="text" name="phone">
		<input type="hidden" name="token" value="$token">
		<input type="submit" name="send" value="SEND">
	</form>
</body>
</html>