<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP for Password Reset</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f4f4f4;">
        <tr>
            <td align="center">
                <table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; margin: 20px 0; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding: 20px 0; background-color: #FA8128; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">Prasthan Yatnam</h1>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="color: #333333; font-size: 20px;">Password Reset Request</h2>
                            <p style="color: #555555; line-height: 1.6;">Hello,</p>
                            <p style="color: #555555; line-height: 1.6;">You are receiving this email because we received a password reset request for your account.</p>
                            <p style="color: #555555; line-height: 1.6;">Your One-Time Password (OTP) is:</p>
                            <p style="font-size: 24px; font-weight: bold; color: #FA8128; letter-spacing: 2px; margin: 20px 0; text-align: center;">{{ $otp }}</p>
                            <p style="color: #555555; line-height: 1.6;">This OTP will expire in 10 minutes.</p>
                            <p style="color: #555555; line-height: 1.6;">If you did not request a password reset, no further action is required.</p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding: 20px 30px; background-color: #f4f4f4; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                            <p style="color: #888888; font-size: 12px; margin: 0;">© {{ date('Y') }} Prasthan Yatnam. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>