<?php
function cleanInput($request) {
    return $request->except(['_token', '_method']);
}
   function formatRupiah($angka)
 {
     return 'Rp ' . number_format($angka, 0, ',', '.');
 }

function apiWa($nohp,$pesan){
    $data = [
            "instance_key" => env('WA_KEY'),
            "jid" => $nohp,
            "message" => $pesan
    ];

    $url = env('WA_URL');
    $curl = curl_init();
    $payload = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'referer:http://localhost:8088'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
    }
    curl_close($ch);

    if (isset($error_msg)) {
        return false;
    }

    return $result;
}


function formatDetikToWaktu($detik) {
    $jam = floor($detik / 3600); // Hitung jumlah jam
    $menit = floor(($detik % 3600) / 60); // Hitung sisa menit

    if ($jam > 0) {
        return "{$jam} jam {$menit} menit"; // Format "X jam Y menit"
    } else {
        return "{$menit} menit"; // Format "Y menit"
    }
}

function formatDetikToMenit($detik)
{
    // Mengubah detik menjadi menit dan membulatkan ke bawah
    return floor($detik / 60);
}

