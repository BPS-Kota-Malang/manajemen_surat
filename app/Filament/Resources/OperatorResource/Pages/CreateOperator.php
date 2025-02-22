<?php

namespace App\Filament\Resources\OperatorResource\Pages;

use Illuminate\Support\Facades\DB;
use App\Filament\Resources\OperatorResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;

class CreateOperator extends CreateRecord
{
    protected static string $resource = OperatorResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        DB::beginTransaction(); // Mulai transaksi

        try {
            // 1️⃣ Buat user baru
            $user = User::create([
                'username' => $data['username'],
                'password' => bcrypt($data['password']),
                'name' => $data['name'],
                'role_id' => $data['role_id'],
                'no_tlp' => $data['no_tlp'],
            ]);
            // 2️⃣ Simpan user_id ke dalam data operator
            $data['user_id'] = $user->user_id;

            // 3️⃣ Hapus data yang tidak ada di tabel operators
            unset($data['username'], $data['password'], $data['name'], $data['role_id'], $data['no_tlp']);

            DB::commit(); // Commit setelah semua proses berhasil

            return $data; // Pastikan data operator dikembalikan
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika error
            throw new \Exception('Gagal membuat operator: ' . $e->getMessage());
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
