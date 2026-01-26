<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{

    /**
     * Número máximo de intentos de login permitidos
     *
     * @var int
     */
    protected $maxAttempts = 5;

    /**
     * Tiempo de bloqueo en minutos después de demasiados intentos
     *
     * @var int
     */
    protected $decayMinutes = 15;

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }
    /**
     * Mostrar formulario de registro
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Procesar el registro de un nuevo usuario
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validar datos
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'Este email ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Iniciar sesión automáticamente
        Auth::login($user);

        return redirect()->route('home')
            ->with('success', '¡Bienvenido ' . $user->name . '! Tu cuenta ha sido creada exitosamente.');
    }

    /**
     * Mostrar formulario de login
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar el login
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validar credenciales
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser válido',
            'password.required' => 'La contraseña es obligatoria',
        ]);

        // Protección contra fuerza bruta (throttling)
        $key = strtolower($request->input('email')).'|'.$request->ip();
        
        if (RateLimiter::tooManyAttempts($key, $this->maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => 'Demasiados intentos de login. Intenta de nuevo en ' . ceil($seconds / 60) . ' minutos.',
            ])->withInput($request->only('email'));
        }

        // Intentar login
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Limpiar intentos de login fallidos
            $key = strtolower($request->input('email')).'|'.$request->ip();
            RateLimiter::clear($key);

            return redirect()->intended(route('home'))
                ->with('success', '¡Bienvenido de nuevo, ' . Auth::user()->name . '!');
        }

        // Incrementar intentos de login fallidos
        $key = strtolower($request->input('email')).'|'.$request->ip();
        RateLimiter::hit($key, $this->decayMinutes * 60);

        // Si falla el login
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput($request->only('email'));
    }

    /**
     * Cerrar sesión
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Sesión cerrada correctamente. ¡Hasta pronto!');
    }
}
