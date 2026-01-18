<!DOCTYPE html>
<html>

<head>
    <title>Account Active</title>
</head>

<body>
    <p>Dear {{ $user->name }},</p>

    <p>Your registration for the <strong>FK Postgraduate Presentation System (FKPPS)</strong> has been approved by the
        Manager.</p>

    <p>You may now login to the system using your registered credentials.</p>

    <p>
        <a href="{{ route('login') }}"
            style="background: #1e3a8a; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Login
            to FKPPS</a>
    </p>

    <p>Thank you,<br>FKPPS Administrator</p>
</body>

</html>
