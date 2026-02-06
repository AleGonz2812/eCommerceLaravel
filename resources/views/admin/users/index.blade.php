@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Usuarios</h2>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="bi bi-box-seam"></i> Gestionar Productos
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($users->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-people" style="font-size: 4rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No hay usuarios registrados aún</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Admin</th>
                                <th>Registrado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <i class="bi bi-person-circle me-2"></i>
                                    {{ $user->name }}
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->is_admin)
                                        <span class="badge bg-danger">Administrador</span>
                                    @else
                                        <span class="badge bg-secondary">Usuario</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal{{ $user->id }}">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>

                                    <!-- Modal de confirmación -->
                                    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Estás seguro de que deseas eliminar al usuario:</p>
                                                    <p class="fw-bold">{{ $user->name }} ({{ $user->email }})?</p>
                                                    <p class="text-danger">Esta acción no se puede deshacer. El usuario deberá registrarse nuevamente para acceder.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Eliminar Usuario</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <p class="text-muted">
                        <i class="bi bi-info-circle"></i> 
                        Total de usuarios: <strong>{{ $users->count() }}</strong>
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
