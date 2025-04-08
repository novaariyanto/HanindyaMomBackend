<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OTPVerification extends Model
{
    //
    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'nomor_hp',
        'otp_code',
        'expires_at',
        'nik'
    ];

    // Metode untuk memeriksa apakah OTP sudah kedaluwarsa
    public function isExpired()
    {
        return now()->greaterThan($this->expires_at);
    }


    // Metode untuk memeriksa apakah OTP cocok dengan input pengguna
    public function isValidOTP($inputOTP)
    {
        return $this->otp_code === $inputOTP && !$this->isExpired();
    }

      // Relasi ke model User
      public function user()
      {
          return $this->belongsTo(User::class, 'nomor_hp', 'username'); // Asumsi NIK digunakan sebagai foreign key
      }

      

}
