<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Prom Night 2025</title>
</head>
<body style="margin:0; padding:0; background-color:#f5f5f5; font-family:Arial, sans-serif;">

  <!-- Outer Container -->
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding:40px 0; background-color:#f5f5f5;">
    <tr>
      <td align="center">

        <!-- Email Container -->
        <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color:#ffffff; border-radius:8px; box-shadow:0 5px 15px rgba(0,0,0,0.1); overflow:hidden;">

          <!-- Header with Banner -->
          <tr>
            <td align="center" style="padding:0;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#1f2937;">
                <tr>
                  <td align="center">
                    <img src="https://imageprom.sgp1.cdn.digitaloceanspaces.com/sample-banner.png" alt="Prom Night 2025 Banner" 
                      width="600" 
                      style="display:block; width:100%; max-width:600px; height:auto; border:none; margin:0; padding:0;">
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Content -->
          <tr>
            <td style="padding:30px 40px; color:#374151; font-size:16px; line-height:1.8;">
              <h2 style="text-align:center; color:#2563eb; margin:0; font-size:20px;">Selamat Datang di</h2>
              <h2 style="text-align:center; color:#2563eb; margin:0; font-size:20px;">Prom Night: Casino de L'Amour</h2>

              <p style="margin:20px 0;">Hai <strong style="color:#2563eb;">{{$data['nama']}}</strong>,</p>
              <p style="margin:10px 0;">Tiketmu untuk <strong>Prom Night 2025</strong> telah berhasil dipesan! Berikut adalah detail tiketmu:</p>

              <!-- Ticket Details -->
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin:20px 0; font-size:15px;">
                <tr>
                  <td style="padding:8px 0;"><strong>Nama:</strong></td>
                  <td style="padding:8px 0;">{{$data['nama']}}</td>
                </tr>
                <tr>
                  <td style="padding:8px 0;"><strong>Email:</strong></td>
                  <td style="padding:8px 0;">{{$data['email']}}</td>
                </tr>
                <tr>
                  <td style="padding:8px 0;"><strong>Nomor Telepon:</strong></td>
                  <td style="padding:8px 0;">{{$data['no_hp']}}</td>
                </tr>
                <tr>
                  <td style="padding:8px 0;"><strong>Metode Bayar:</strong></td>
                  <td style="padding:8px 0;">{{$data['metodebayar']}}</td>
                </tr>
                <tr>
                  <td style="padding:8px 0;"><strong>Order ID:</strong></td>
                  <td style="padding:8px 0;">{{$data['order_id']}}</td>
                </tr>
              </table>

              <!-- QR Code -->
              <div style="text-align:center; margin:30px 0;">
                <p style="margin-bottom:10px;">Scan QR Code ini saat check-in:</p>
                <img src="https://quickchart.io/qr?text={{$data['order_id']}}&size=200" 
                  alt="QR Code Tiket" width="200" height="200" style="border:0;">
              </div>

              <!-- Lihat Tiket Button -->
              <div style="text-align:center; margin:30px 0;">
                <a href="{{$data['url']}}" style="display:inline-block; padding:14px 28px; background-color:#2563eb; color:#ffffff; text-decoration:none; border-radius:6px; font-weight:bold; font-size:16px;">
                  Lihat Tiket 🎫
                </a>
              </div>

              <p style="margin-top:30px; font-size:14px; color:#6b7280; text-align:center;">Harap tunjukkan QR code ini saat tiba di acara, dan jangan bagikan link ini ke orang lain untuk menjaga keamanan tiketmu.</p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td align="center" style="padding:20px; background-color:#f9fafb; border-top:1px solid #e5e7eb; font-size:12px; color:#6b7280;">
              <p style="margin:0;">Butuh bantuan? Hubungi kami di <a href="https://wa.me/6285222928594" style="color:#2563eb; text-decoration:underline;">WhatsApp</a></p>
              <p style="margin-top:10px;">&copy; 2025 Prom Night Committee</p>
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>

</body>
</html>
