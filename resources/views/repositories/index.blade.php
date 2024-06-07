@section('title')
    Repositorio
@endsection
@section('custom-css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <!-- Puedes agregar más archivos CSS específicos aquí -->
@endsection
<x-header-footer>
    <div class="row justify-content-center mt-5">
        <div class="col-7">
            <form action="/repositories/view" method="POST"  id="myForm" enctype="multipart/form-data">
                <table class="table custom-table">
                        @csrf
                    <tbody>
                        <thead>
                            <tr>
                                <td colspan="2">
                                    @if ($type == 'update')
                                        <h2 style="color: white">Actualizar Repositorio</h2>
                                        <p>Al actualizar un repositorio usted podrá visualizar una vista previa de él.</p> 
                                    @else
                                        <h2 style="color: white">Subir Repositorio</h2>
                                        <p>Al subir un repositorio usted podrá visualizar una vista previa de él.</p>
                                    @endif
                                    
                                </td>
                            </tr>
                        </thead>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text color_index" id="basic-addon1">Repositorio</span>
                                    <input type="text" class="form-control color_index" placeholder="Nombre de repositorio" aria-label="Username" aria-describedby="basic-addon1"  value="{{$repositories->name_repo}}"  disabled>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="file" class="form-control" id="inputGroupFile02" name="files" accept=".zip" required>
                                    <label class="input-group-text color_index" for="inputGroupFile02">.zip</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="form-floating">
                                    <textarea class="form-control text_description" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="update_comment" rows="2" required></textarea>
                                    @if ($type == 'update')
                                        <label for="floatingTextarea2">Comentario de actualización (requerido)</label>
                                    @else
                                        <label for="floatingTextarea2">Comentario de inserción (requerido)</label>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tbody>
                        <input type="text" name="id" value="{{$repositories->id}}" hidden>
                        <input type="text" name="name_repo" value="{{$repositories->name_repo}}" hidden>
                </table>
                <div class="button-container mt-3">
                    
                    @if ($type == 'update')
                        <a href="/files/index/{{$repositories->id}}"class="btn btn-primary" tabindex="-1" role="button"><i class="fa-solid fa-chevron-left"></i>&nbsp;&nbsp;Regresar</a>
                        <button type="submit" class="btn btn-warning" id="updateButton"><i class="fa-solid fa-book"></i>&nbsp;&nbsp;Actualizar Repositorio&nbsp;&nbsp;</button>
                    @else
                        <a href="/" class="btn btn-primary" tabindex="-1" role="button"><i class="fa-solid fa-chevron-left"></i>&nbsp;&nbsp;Regresar</a>
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-book"></i>&nbsp;&nbsp;Subir Repositorio&nbsp;&nbsp;</button>
                    @endif
                </div>   
            </form>
        </div>
    </div>

    @section('custom-js')
        <script src="{{ asset('js/layout.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('myForm');
                const button = document.getElementById('updateButton');

                button.addEventListener('click', function (event) {
                    event.preventDefault(); // Prevenir el envío del formulario

                    // Si el formulario es válido, mostrar SweetAlert
                    if (form.checkValidity()) {
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-danger"
                            },
                            buttonsStyling: false
                        });

                        swalWithBootstrapButtons.fire({
                            title: "¿Estás seguro?",
                            text: "¡Podrás revertir tus cambios en el apartado de commits!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Sí, actualiza!",
                            cancelButtonText: "No, cancélalo!",
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // Enviar el formulario manualmente
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                swalWithBootstrapButtons.fire({
                                    title: "Cancelado",
                                    text: "No se ha realizado ningún cambio.",
                                    icon: "info"
                                });
                            }
                        });
                    } else {
                        // Mostrar mensajes de validación del navegador
                        form.reportValidity();
                    }
                });
            });
        </script>
        <!-- Puedes agregar más archivos JS específicos aquí -->
    @endsection
</x-header-footer>

