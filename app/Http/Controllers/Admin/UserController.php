<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of all users
     */
    public function index()
    {
        // Obtener todos los usuarios excepto el admin actual
        $users = User::where('id', '!=', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Remove the specified user from storage
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // No permitir que el admin se elimine a sí mismo
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propia cuenta');
        }

        $userName = $user->name;
        
        // Eliminar el usuario (esto eliminará automáticamente sus relaciones por cascade)
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Usuario '{$userName}' eliminado exitosamente");
    }
}
