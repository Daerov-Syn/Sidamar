<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Admin::orderBy('id', 'asc')->get();
        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function create()
    {
        return view('admin.pengguna.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:admins,username'],
            'email'    => ['required', 'string', 'email', 'max:150'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'username.required'   => 'Username wajib diisi.',
            'username.unique'     => 'Username ini sudah digunakan.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'password.required'   => 'Password wajib diisi.',
            'password.min'        => 'Password minimal 6 karakter.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
        ]);

        Admin::create([
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna administrator baru berhasil ditambahkan.');
    }

    public function edit(Admin $admin)
    {
        return view('admin.pengguna.edit', ['pengguna' => $admin]);
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('admins', 'username')->ignore($admin->id)],
            'email'    => ['required', 'string', 'email', 'max:150'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'username.required'   => 'Username wajib diisi.',
            'username.unique'     => 'Username ini sudah digunakan.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'password.min'        => 'Password minimal 6 karakter jika ingin diubah.',
            'password.confirmed'  => 'Konfirmasi password baru tidak cocok.',
        ]);

        $data = [
            'username' => $validated['username'],
            'email'    => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $admin->update($data);

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->id === auth('admin')->id()) {
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        if (Admin::count() <= 1) {
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Tidak dapat menghapus administrator terakhir.');
        }

        $admin->delete();

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna administrator berhasil dihapus.');
    }
}

