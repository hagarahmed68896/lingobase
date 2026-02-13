<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
        <h2 style="color: #009150; border-bottom: 2px solid #009150; padding-bottom: 10px;">New Contact Message</h2>
        <p><strong>Name:</strong> {{ $details['name'] }}</p>
        <p><strong>Email:</strong> {{ $details['email'] }}</p>
        <p><strong>Message:</strong></p>
        <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; border-left: 4px solid #009150;">
            {{ $details['message'] }}
        </div>
        <p style="margin-top: 20px; font-size: 0.8rem; color: #777;">This message was sent via the LingoBase contact form.</p>
    </div>
</body>
</html>
