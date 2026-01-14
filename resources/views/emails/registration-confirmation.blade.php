<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #2563eb; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 20px; border: 1px solid #e5e7eb; }
        .registration-number { background: #dbeafe; border: 2px solid #2563eb; padding: 15px; text-align: center; margin: 20px 0; border-radius: 8px; }
        .registration-number h2 { color: #1d4ed8; margin: 0; font-size: 24px; }
        .details { background: white; padding: 15px; border-radius: 8px; margin: 15px 0; }
        .details table { width: 100%; border-collapse: collapse; }
        .details td { padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
        .details td:first-child { color: #6b7280; width: 40%; }
        .details td:last-child { font-weight: 500; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 14px; }
        .btn { display: inline-block; background: #2563eb; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Pendaftaran Berhasil!</h1>
    </div>
    
    <div class="content">
        <p>Halo <strong>{{ $registration->name }}</strong>,</p>
        
        <p>Terima kasih telah mendaftar. Pendaftaran Anda telah berhasil diproses.</p>
        
        <div class="registration-number">
            <p style="margin: 0 0 5px 0; color: #2563eb;">Nomor Pendaftaran Anda</p>
            <h2>{{ $registration->registration_number }}</h2>
        </div>
        
        <div class="details">
            <h3 style="margin-top: 0;">Detail Pendaftaran</h3>
            <table>
                <tr>
                    <td>Nama Lengkap</td>
                    <td>{{ $registration->name }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $registration->email }}</td>
                </tr>
                <tr>
                    <td>No. HP</td>
                    <td>{{ $registration->phone }}</td>
                </tr>
                <tr>
                    <td>Jalur Pendaftaran</td>
                    <td>{{ $registration->registrationPath->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Program Studi Pilihan 1</td>
                    <td>{{ $registration->firstChoiceProgram->name ?? '-' }}</td>
                </tr>
                @if($registration->secondChoiceProgram)
                <tr>
                    <td>Program Studi Pilihan 2</td>
                    <td>{{ $registration->secondChoiceProgram->name }}</td>
                </tr>
                @endif
                <tr>
                    <td>Total Pembayaran</td>
                    <td style="color: #2563eb; font-weight: bold;">Rp {{ number_format($registration->final_amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Status Pembayaran</td>
                    <td>
                        @if($registration->payment_status === 'paid')
                            <span style="color: #16a34a;">✓ Lunas</span>
                        @else
                            <span style="color: #ca8a04;">⏳ Menunggu Pembayaran</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        
        @if($registration->payment_status !== 'paid')
        <div style="background: #fef3c7; border: 1px solid #f59e0b; padding: 15px; border-radius: 8px; margin: 15px 0;">
            <h4 style="margin: 0 0 10px 0; color: #92400e;">⚠️ Langkah Selanjutnya</h4>
            <p style="margin: 0; color: #92400e;">Silakan segera lakukan pembayaran untuk menyelesaikan proses pendaftaran Anda. Simpan nomor pendaftaran di atas untuk keperluan konfirmasi pembayaran.</p>
        </div>
        @endif
        
        <p>Jika Anda memiliki pertanyaan, silakan hubungi kami melalui WhatsApp atau email.</p>
        
        <p>Salam,<br><strong>Tim Pendaftaran {{ config('app.name') }}</strong></p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
    </div>
</body>
</html>
