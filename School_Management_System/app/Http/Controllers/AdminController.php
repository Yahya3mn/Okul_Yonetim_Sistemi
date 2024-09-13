<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function list()
    {
        // Admin listesi için veriyi al
        $data['getRecord'] = User::getAdmin();
        $data['header_title'] = "Admin List";
        return view('admin.admin.list', $data);
    }

    public function add()
    {
        // Yeni admin ekleme sayfası için başlık ayarla
        $data['header_title'] = "Add New Admin";
        return view('admin.admin.add', $data);
    }

    public function insert(Request $request)
    {
        // Form validasyonu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Yeni kullanıcı oluştur
        $user = new User;
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make(trim($request->password));
        $user->user_type = 1;
        $user->save();

        return redirect('admin/admin/list')->with('success', "Admin successfully added");
    }

    public function edit($id)
    {
        // Düzenlenecek admin kaydını al
        $data['getRecord'] = User::getSingle($id);
        if (!empty($data['getRecord'])) {
            $data['header_title'] = "Edit Admin";
            return view('admin.admin.edit', $data);
        } else {
            abort(404);
        }
    }

    public function update($id, Request $request)
    {
        // Form validasyonu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        // Güncellenen kullanıcıyı al
        $user = User::getSingle($id);
        if ($user) {
            $user->name = trim($request->name);
            $user->email = trim($request->email);
            if (!empty($request->password)) {
                $user->password = Hash::make(trim($request->password));
            }
            $user->save();

            return redirect('admin/admin/list')->with('success', "Admin successfully updated");
        } else {
            abort(404);
        }
    }

    public function delete($id)
    {
        // Silinecek kullanıcıyı al
        $user = User::getSingle($id);
        if ($user) {
            $user->is_delete = 1;
            $user->save();

            return redirect('admin/admin/list')->with('success', "Admin successfully deleted");
        } else {
            abort(404);
        }
    }
}
