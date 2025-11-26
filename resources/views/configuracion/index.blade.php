@extends('layouts.app')

@section('title', 'Configuración - SilverGym')

@section('content')
<div style="padding: 30px;">
    <div style="margin-bottom: 25px;">
        <h1 style="font-size: 32px; font-weight: bold; color: #1e88e5;">
            <i class="fas fa-cog"></i> Configuración del Gimnasio
        </h1>
        <p style="color: #666; margin-top: 10px;">Administra la información que aparece en las credenciales y documentos del gimnasio.</p>
    </div>

    @if(session('success'))
        <div style="padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
        <!-- Formulario de Configuración -->
        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="color: #333; margin-bottom: 20px; font-size: 20px; border-bottom: 2px solid #1e88e5; padding-bottom: 10px;">
                <i class="fas fa-edit"></i> Datos del Gimnasio
            </h3>
            
            <form method="POST" action="{{ route('configuracion.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">
                        <i class="fas fa-building"></i> Nombre del Gimnasio
                    </label>
                    <input type="text" name="nombre_gimnasio" value="{{ old('nombre_gimnasio', $config['nombre_gimnasio']) }}" required 
                        style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;"
                        onfocus="this.style.borderColor='#1e88e5'" onblur="this.style.borderColor='#e0e0e0'">
                    @error('nombre_gimnasio')
                        <small style="color: #f44336; margin-top: 5px; display: block;">{{ $message }}</small>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">
                        <i class="fas fa-phone"></i> Teléfono
                    </label>
                    <input type="text" name="telefono" value="{{ old('telefono', $config['telefono']) }}" required 
                        style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;"
                        onfocus="this.style.borderColor='#1e88e5'" onblur="this.style.borderColor='#e0e0e0'">
                    @error('telefono')
                        <small style="color: #f44336; margin-top: 5px; display: block;">{{ $message }}</small>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">
                        <i class="fas fa-map-marker-alt"></i> Dirección
                    </label>
                    <textarea name="direccion" rows="3" required 
                        style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: border-color 0.3s; resize: vertical;"
                        onfocus="this.style.borderColor='#1e88e5'" onblur="this.style.borderColor='#e0e0e0'">{{ old('direccion', $config['direccion']) }}</textarea>
                    @error('direccion')
                        <small style="color: #f44336; margin-top: 5px; display: block;">{{ $message }}</small>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 600;">
                        <i class="fas fa-image"></i> Logo del Gimnasio
                    </label>
                    <input type="file" name="logo" accept="image/*" 
                        style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;"
                        onchange="previewLogo(event)">
                    <small style="color: #666; display: block; margin-top: 5px;">
                        <i class="fas fa-info-circle"></i> Formatos permitidos: JPG, PNG, GIF (máx. 2MB)
                    </small>
                    @error('logo')
                        <small style="color: #f44336; margin-top: 5px; display: block;">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #1e88e5, #1565c0); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: transform 0.2s;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <i class="fas fa-save"></i> Guardar Configuración
                </button>
            </form>
        </div>

        <!-- Vista Previa -->
        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="color: #333; margin-bottom: 20px; font-size: 20px; border-bottom: 2px solid #4caf50; padding-bottom: 10px;">
                <i class="fas fa-eye"></i> Vista Previa
            </h3>

            <!-- Logo Actual -->
            <div style="text-align: center; margin-bottom: 30px;">
                <p style="color: #666; margin-bottom: 15px; font-weight: 600;">Logo Actual:</p>
                @if(isset($config['logo']) && $config['logo'])
                    <img id="currentLogo" src="{{ asset('storage/' . $config['logo']) }}" alt="Logo" 
                        style="max-width: 200px; max-height: 200px; border: 3px solid #e0e0e0; border-radius: 12px; padding: 10px; background: white;">
                @else
                    <div id="currentLogo" style="width: 200px; height: 200px; margin: 0 auto; background: #f5f5f5; border: 3px dashed #ccc; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #999;">
                        <div style="text-align: center;">
                            <i class="fas fa-image" style="font-size: 48px; margin-bottom: 10px; display: block;"></i>
                            Sin logo
                        </div>
                    </div>
                @endif
            </div>

            <!-- Preview del nuevo logo -->
            <div id="newLogoPreview" style="text-align: center; margin-bottom: 30px; display: none;">
                <p style="color: #4caf50; margin-bottom: 15px; font-weight: 600;">Nuevo Logo:</p>
                <img id="previewImage" src="" alt="Preview" 
                    style="max-width: 200px; max-height: 200px; border: 3px solid #4caf50; border-radius: 12px; padding: 10px; background: white;">
            </div>

            <!-- Información del Gimnasio -->
            <div style="background: linear-gradient(135deg, #1e88e5, #1565c0); color: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                <h4 style="margin: 0 0 15px 0; font-size: 24px; border-bottom: 2px solid rgba(255,255,255,0.3); padding-bottom: 10px;">
                    {{ $config['nombre_gimnasio'] }}
                </h4>
                <p style="margin: 10px 0; display: flex; align-items: center;">
                    <i class="fas fa-phone" style="margin-right: 10px; width: 20px;"></i>
                    {{ $config['telefono'] }}
                </p>
                <p style="margin: 10px 0; display: flex; align-items: flex-start;">
                    <i class="fas fa-map-marker-alt" style="margin-right: 10px; width: 20px; margin-top: 3px;"></i>
                    {{ $config['direccion'] }}
                </p>
            </div>

            <div style="margin-top: 20px; padding: 15px; background: #e3f2fd; border-left: 4px solid #2196f3; border-radius: 4px;">
                <p style="margin: 0; color: #1565c0; font-size: 14px;">
                    <i class="fas fa-info-circle"></i> 
                    Esta información aparecerá en las credenciales de los miembros y en los documentos del gimnasio.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function previewLogo(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('newLogoPreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
