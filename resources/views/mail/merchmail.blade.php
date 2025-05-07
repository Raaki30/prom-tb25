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
              <h2 style="text-align:center; color:#2563eb; margin:0; font-size:20px;">Terima kasih Atas Pembelian Merch</h2>
              <h2 style="text-align:center; color:#2563eb; margin:0; font-size:20px;">Prom Night: Casino de L'Amour</h2>

              <p style="margin:20px 0;">Hai <strong style="color:#2563eb;">{{$data['nama']}}</strong>,</p>
              <p style="margin:10px 0;">Terima kasih telah membeli merchandise <strong>Prom Night 2025</strong>. Berikut ini detail pesanan kamu</p>

              <!-- Order ID Highlight -->
              <div style="background-color:#d1fae5; border-left:4px solid #10b981; padding:16px; border-radius:6px; text-align:center; margin:20px 0;">
                <p style="margin:0; font-size:20px; font-weight:bold; color:#065f46; letter-spacing:1px;">{{$data['order_id']}}</p>
              </div>

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
                  <td style="padding:8px 0;"><strong>Total:</strong></td>
                  <td style="padding:8px 0;">{{$data['grand_total']}}</td>
                </tr>
              </table>

              <!-- Item List -->
              <h3 style="margin-top:30px; font-size:18px; color:#2563eb;">Rincian Merchandise</h3>
              <table role="presentation" width="100%" cellspacing="0" cellpadding="8" style="border:1px solid #e5e7eb; font-size:14px; border-collapse:collapse; margin-top:10px;">
                <thead style="background-color:#f3f4f6; color:#111827;">
                  <tr>
                    <th align="left" style="border:1px solid #e5e7eb;">Produk</th>
                    <th align="center" style="border:1px solid #e5e7eb;">Jumlah</th>
                    <th align="right" style="border:1px solid #e5e7eb;">Harga</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $productNames = [
                      'TB01' => 'Tote Bag Casino Design - Regular',
                      'TB02' => 'Tote Bag Cards Design - Regular',
                      'TM01' => 'Tumbler Casino Design - 500ml',
                      'TM02' => 'Tumbler Cards Design - 500ml',
                      'LN01' => 'Lanyard Casino Design - Standard',
                      'LN02' => 'Lanyard Cards Design - Standard',
                      'EP01' => 'Enamel Pin Casino Design - Small',
                      'EP02' => 'Enamel Pin Cards Design - Small',
                    ];
                  @endphp

                  @foreach($data['items'] as $item)
                    <tr>
                      <td style="border:1px solid #e5e7eb;">{{ $productNames[$item['product_id']] ?? $item['product_id'] }}</td>
                      <td align="center" style="border:1px solid #e5e7eb;">{{ $item['quantity'] }}</td>
                      <td align="right" style="border:1px solid #e5e7eb;">Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              <p style="margin-top:30px; font-size:14px; color:#6b7280; text-align:center;">Kamu bisa mengambil pesanan kamu di area pengambilan dengan menunjukkan email ini</p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td align="center" style="padding:20px; background-color:#f9fafb; border-top:1px solid #e5e7eb; font-size:12px; color:#6b7280;">
              <p style="margin:0;">Butuh bantuan? Hubungi kami di <a href="https://wa.me/6281234567890" style="color:#2563eb; text-decoration:underline;">WhatsApp</a></p>
              <p style="margin-top:10px;">&copy; 2025 Prom Night Committee</p>
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>

</body>
</html>
