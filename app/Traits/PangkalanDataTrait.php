<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait PangkalanDataTrait {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    
     protected function uploadMahasiswaDokumen($validasi, $request, $data)
     {
        if ($request->upload1) {
            if ($data->upload1 ?? null) {
                Storage::delete($data->upload1);
                $validasi['upload1'] = NULL;
            }
            $path = Storage::putFile('public', $request->file('upload1'));
            $validasi['upload1'] = $path;
        }

        if ($request->upload2) {
            if ($data->upload2 ?? null) {
                Storage::delete($data->upload2);
                $validasi['upload2'] = NULL;
            }
            $path = Storage::putFile('public', $request->file('upload2'));
            $validasi['upload2'] = $path;
        }

        if ($request->upload3) {
            if ($data->upload3 ?? null) {
                Storage::delete($data->upload3);
                $validasi['upload3'] = NULL;
            }
            $path = Storage::putFile('public', $request->file('upload3'));
            $validasi['upload3'] = $path;
        }

        if ($request->upload4) {
            if ($data->upload4 ?? null) {
                Storage::delete($data->upload4);
                $validasi['upload4'] = NULL;
            }
            $path = Storage::putFile('public', $request->file('upload4'));
            $validasi['upload4'] = $path;
        }

        if ($request->upload5) {
            if ($data->upload5 ?? null) {
                Storage::delete($data->upload5);
                $validasi['upload5'] = NULL;
            }
            $path = Storage::putFile('public', $request->file('upload5'));
            $validasi['upload5'] = $path;
        }

        if ($request->upload6) {
            if ($data->upload6 ?? null) {
                Storage::delete($data->upload6);
                $validasi['upload6'] = NULL;
            }
            $path = Storage::putFile('public', $request->file('upload6'));
            $validasi['upload6'] = $path;
        }

        if ($request->upload7) {
            if ($data->upload7 ?? null) {
                Storage::delete($data->upload7);
                $validasi['upload7'] = NULL;
            }
            $path = Storage::putFile('public', $request->file('upload7'));
            $validasi['upload7'] = $path;
        }

        if ($request->upload8) {
            if ($data->upload8 ?? null) {
                Storage::delete($data->upload8);
                $validasi['upload8'] = NULL;
            }
            $path = Storage::putFile('public', $request->file('upload8'));
            $validasi['upload8'] = $path;
        }

        return $validasi;
     }

     protected function uploadSkDosen($validasi, $request)
     {
        $path = Storage::putFile('public', $request->file('upload'));
        $validasi['upload'] = $path;

        return $validasi;
     }

     protected function updateUploadSkDosen($validasi, $request, $data)
     {
        if ($request->upload) {
            if ($data->upload ?? null) {
                Storage::delete($data->upload);
                $validasi['upload'] = NULL;
            }
            $path = Storage::putFile('public', $request->file('upload'));
            $validasi['upload'] = $path;
        }

        return $validasi;
     }


}