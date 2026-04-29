<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome Email</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9fafb; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="background-color: #ffffff; padding: 20px;">
                <!-- Logo -->
                <img src="{{ asset('image/logonew1.png') }}" alt="Company Logo" style="max-width: 150px;">
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 20px;">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                    <tr>
                        <td>
                            <h2 style="color: #333;">Hello {{ $user->name }}, 🎉</h2>
                            <p style="color: #555; font-size: 16px;">
                                Welcome to <strong>Sweton Speakers</strong>! We’re excited to have you on board.
                            </p>
                            <p style="color: #555; font-size: 16px;">
                                You can now log in to your dashboard and start exploring.
                            </p>
                            <p style="margin-top: 30px;">
                                <a href="{{ url('/dashboard') }}" style="background-color: #4f46e5; color: #ffffff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold;">
                                    Go to Dashboard
                                </a>
                            </p>
                            <p style="color: #888; font-size: 14px; margin-top: 40px;">
                                — The Sweton Speakers Team
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
