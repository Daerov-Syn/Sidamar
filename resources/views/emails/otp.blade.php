<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; max-width: 480px; margin: 0 auto; }
        .header { background: #0D47A1; color: white; padding: 24px; text-align: center; border-radius: 8px 8px 0 0; }
        .body { background: #f5f5f5; padding: 32px; }
        .kode { font-size: 36px; font-weight: bold; letter-spacing: 12px; color: #0D47A1;
                text-align: center; background: white; padding: 16px; border-radius: 8px;
                border: 2px dashed #0D47A1; margin: 24px 0; }
        .footer { background: #e0e0e0; padding: 16px; text-align: center; font-size: 12px;
                  color: #666; border-radius: 0 0 8px 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin:0">🔐 SiDamar Admin</h2>
        <p style="margin:8px 0 0; opacity:.85">Kode Verifikasi OTP</p>
    </div>
    <div class="body">
        <p>Halo <strong>{{ $username }}</strong>,</p>
        <p>Berikut kode OTP Anda untuk login ke Panel Admin SiDamar:</p>
        <div class="kode">{{ $kode }}</div>
        <p>Kode berlaku selama <strong>5 menit</strong> dan hanya dapat digunakan satu kali.</p>
        <p style="color:#c62828"><strong>⚠️ Jangan bagikan kode ini kepada siapapun!</strong></p>
        <p>Jika Anda tidak merasa melakukan login, abaikan email ini.</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} SiDamar — Samsat Manyar, Surabaya Timur
    </div>
</body>
</html>
