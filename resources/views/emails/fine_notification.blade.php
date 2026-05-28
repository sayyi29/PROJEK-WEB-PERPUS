<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; background-color: #0f172a; color: #ffffff; padding: 40px; border-radius: 20px;">
    <h2 style="color: #6366f1;">Halo, {{ $fine->user->name }}!</h2>
    <p>Kami memberitahukan bahwa Anda memiliki denda keterlambatan buku di LUMINA.</p>
    <div style="background: #1e293b; padding: 20px; border-radius: 10px; margin: 20px 0;">
        <p><strong>Buku:</strong> {{ $fine->borrowing->book->title }}</p>
        <p><strong>Jumlah Denda:</strong> Rp {{ number_format($fine->amount, 0, ',', '.') }}</p>
    </div>
    <p>Mohon segera selesaikan pembayaran di perpustakaan.</p>
    <br>
    <p>Salam hangat,<br><strong>LUMINA Library Team</strong></p>
</body>
</html>
