<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode OTP Anda - Sitani</title>
</head>
<body style="margin:0; padding:0; background:#f6f8fa; font-family: Arial, sans-serif;">
    <table width="100%" bgcolor="#f6f8fa" cellpadding="0" cellspacing="0" style="padding: 48px 0;">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:480px; margin:auto; background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.04);">
                    <tr>
                        <td style="padding:32px 32px 0 32px;">
                            <div style="text-align:center; margin-bottom:16px;">
                                {{-- Nanti bisa diganti dengan logo kalau mau --}}
                                <span style="font-family: 'Marck Script', cursive; font-size:2rem; color:#569B41;">Sitani</span>
                            </div>
                            <h2 style="color: #32325d; text-align:center; margin-bottom:20px;">Kode OTP Anda</h2>
                            <p style="color: #333; font-size:16px; text-align:center;">
                                Hai,
                                <br><br>
                                Berikut adalah kode OTP untuk aplikasi <strong>Sitani</strong> - Dinas Pertanian Kabupaten Nganjuk:<br>
                            </p>
                            <div style="width:100%; text-align:center; margin:32px 0;">
                                <span style="display:inline-block; padding:18px 36px; font-size:2rem; background:#f0fff3; color:#217335; border-radius:8px; letter-spacing:6px; font-weight: bold; border:1.5px solid #bfeaca;">
                                    <?php echo e($code); ?>
                                </span>
                            </div>
                            <p style="color: #555; font-size:15px; text-align:center; line-height:1.6;">
                                Silakan masukkan kode di atas pada aplikasi Sitani untuk melanjutkan proses Anda.
                                <br>
                                Demi keamanan, <strong>jangan berikan kode ini kepada siapapun.</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 32px 32px 32px;">
                            <hr style="margin: 48px 0 24px 0; border:none; border-top:1px solid #eaeaea;">
                            <p style="color:#888; font-size:12px; text-align:center;">
                                Anda menerima email ini karena terdaftar pada aplikasi Sitani -
                                Dinas Pertanian Kabupaten Nganjuk.<br>
                                Jika Anda tidak merasa melakukan permintaan kode OTP, silakan abaikan email ini.
                            </p>
                            <div style="text-align:center; margin-top:18px; color:#bdbdbd; font-size:11px;">
                                &copy; {{ date('Y') }} Sitani · Dinas Pertanian Kab. Nganjuk
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
