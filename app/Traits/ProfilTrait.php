<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait ProfilTrait {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    
     protected function uploadDokumen($validasi, $request)
     {
        if ($request->sk_akreditasi) {
            $path = Storage::putFile('public', $request->file('sk_akreditasi'));
            $validasi['sk_akreditasi'] = $path;
        }

        if ($request->sk_akreditasi_internasional) {
            $path = Storage::putFile('public', $request->file('sk_akreditasi_internasional'));
            $validasi['sk_akreditasi_internasional'] = $path;
        }

        return $validasi;
     }

     protected function hapusUploadProfil($data, $request, $validasi)
    {
        if ($request->sk_akreditasi) {
            if ($data->sk_akreditasi) {
                Storage::delete($data->sk_akreditasi);
                $validasi['sk_akreditasi'] = NULL;
            }
        }

        if ($request->sk_akreditasi_internasional) {
            if ($data->sk_akreditasi_internasional) {
                Storage::delete($data->sk_akreditasi_internasional);
                $validasi['sk_akreditasi_internasional'] = NULL;
            }
        }

        return $validasi;
    }

}