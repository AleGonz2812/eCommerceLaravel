@extends('layouts.app')

@section('title', 'Añadir Producto')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Añadir Nuevo Producto</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del Producto *</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Precio --}}
                        <div class="mb-3">
                            <label for="price" class="form-label">Precio (€) *</label>
                            <input type="number" 
                                   class="form-control @error('price') is-invalid @enderror" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price') }}" 
                                   step="0.01" 
                                   min="0" 
                                   required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Stock --}}
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock *</label>
                            <input type="number" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" 
                                   name="stock" 
                                   value="{{ old('stock') }}" 
                                   min="0" 
                                   required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Categoría --}}
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Categoría *</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" 
                                    name="category_id" 
                                    required>
                                <option value="">Selecciona una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Imagen --}}
                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen del Producto *</label>
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*" 
                                   required>
                            <small class="text-muted">Formatos: JPG, PNG, GIF. Máximo 2MB</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Destacado --}}
                        <div class="mb-3 form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   id="featured" 
                                   name="featured" 
                                   value="1" 
                                   {{ old('featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">
                                Producto destacado (aparecerá en la página principal)
                            </label>
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar Producto
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
