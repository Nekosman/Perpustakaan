<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
    public function input()
    {
        return view('input_member');
    }

    public function kirim(Request $request)
    {
        $validateData = $request->validate([
            'ktp' => 'required|min:unique:members',
            'nama' => 'required',
            'umur' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'sekolah' => 'required',
        ]);

        Member::create($validateData);

        return redirect('tampil_member')->with('status', 'Data member berhasil diinput');
    }

    public function tampil()
    {
        $data = Member::all();
        return view('tampil_member', ['data' => $data]);
    }

    public function delete($ktp)
    {
        $model = Member::find($ktp);
        $model->delete();
        return redirect('tampil_member')->with('status-deleted', 'Data member telah dihapus');
    }

    public function edit($ktp)
    {
        $model = Member::find($ktp);
        return view('edit_member')->with('post', $model);
    }

    public function update(Request $request, $ktp)
    {
        $model = Member::find($ktp);
        $validateData = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'umur' => 'required',
            'jenis_kelamin' => 'required',
            'sekolah' => 'required',
        ]);

        if ($request->ktp != $model->ktp) {
            $rules['ktp'] = 'required|unique:members';

            Member::where('ktp', $model->ktp)
                ->update($validateData);

            return redirect('tampil_member')->with('status', 'Data member berhasil diupdate');
        } else {
            $model->update($validateData);
            return redirect('tampil_member')->with('status', 'Data member berhasil diupdate');
        }
    }
}
