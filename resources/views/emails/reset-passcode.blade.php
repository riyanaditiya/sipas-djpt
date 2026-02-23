<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin:0;padding:0;background-color:#f8fafc;font-family:Arial,'Segoe UI',sans-serif;color:#334155;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border:1px solid #e2e8f0;border-radius:8px;">
                    <tr>
                        <td align="center" style="padding:35px 30px;border-bottom:1px solid #f1f5f9;">
                            <div
                                style="font-size:22px;font-weight:bold;color:#1e40af;letter-spacing:1px;text-transform:uppercase;">
                                {{ config('app.name') }}
                            </div>
                            <div style="font-size:12px;color:#64748b;margin-top:5px;letter-spacing:2px;">
                                DIREKTORAT JENDERAL PERIKANAN TANGKAP
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px 30px;font-size:15px;line-height:1.6;">
                            <p>Yth. <strong>{{ $userName }}</strong>,</p>

                            <p>Kami menerima permintaan atur ulang passcode untuk dokumen
                                <strong>{{ $documentName }}</strong> pada sistem <strong>SIPAS DJPT</strong>.
                            </p>

                            <div style="text-align:center;margin:35px 0;">
                                <a href="{{ $url }}"
                                    style="background:#1e40af;color:#ffffff;padding:14px 28px;text-decoration:none;border-radius:6px;font-weight:bold;display:inline-block;">
                                    ATUR ULANG PASSCODE
                                </a>
                            </div>

                            <div
                                style="font-size:13px;color:#64748b;background:#f1f5f9;padding:15px;border-radius:6px;border-left:4px solid #cbd5e1;">
                                Tautan ini bersifat rahasia dan akan kedaluwarsa dalam waktu <strong>60 menit</strong>.
                                Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini.
                            </div>

                            <p style="margin-top:30px;">
                                Hormat kami,<br>
                                <strong>Administrator SIPAS DJPT</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center"
                            style="padding:30px;font-size:11px;color:#94a3b8;background-color:#fcfdfe;border-bottom-left-radius:8px;border-bottom-right-radius:8px;">
                            <strong>Direktorat Jenderal Perikanan Tangkap</strong><br>
                            Kementerian Kelautan dan Perikanan Republik Indonesia
                            <br><br>
                            &copy; {{ date('Y') }} SIPAS DJPT – Sistem Informasi Pengelolaan Arsip
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
