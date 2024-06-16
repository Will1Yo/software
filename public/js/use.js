document.addEventListener('DOMContentLoaded', function () {
    const usersFinderInput = document.getElementById('users_finder');
    const resultsDivs = document.getElementsByClassName('results'); // Selecciona todos los elementos con la clase 'results'
    const selectedUserDiv = document.querySelector('.selected-user');
    const selectedUserAvatar = document.querySelector('.selected-user-avatar');
    const selectedUserName = document.querySelector('.selected-user-name');
    const selectedUserEmail = document.querySelector('.selected-user-email');
    const addCollaboratorBtn = document.querySelector('.add-collaborator-btn');
    const deselectUserBtn = document.querySelector('.deselect-user');
    const searchLabel = document.querySelector('.search-input');
    const text_search = document.querySelector('.text_search');
    const repoId = usersFinderInput.getAttribute('data-repo');
    const usuariosFinderInput = document.getElementById('usuarios_finder');
    let collaboratorsRows = document.querySelectorAll('.collaborators');
    var iconsDelete = document.querySelectorAll('.icon-delete');
    const tableBody = document.querySelector('.custom-table tbody'); // Selecciona el tbody de la tabla
    


    usersFinderInput.addEventListener('input', function () {
        const query = usersFinderInput.value;

        if (query.length > 0) {
            fetch(`/search-users?user=${query}&repo=${repoId}&validar=users`)
                .then(response => response.json())
                .then(data => {
                    Array.from(resultsDivs).forEach(resultsDiv => {
                        resultsDiv.innerHTML = ''; // Clear previous results
                        data.repositories.forEach(user => {
                            // Crear elemento <li>
                            const repoItem = document.createElement('li');
                            repoItem.classList.add('list-group-item');
                            repoItem.dataset.userId = user.id;
                            repoItem.dataset.userName = user.name;
                            repoItem.dataset.userEmail = user.email;

                            // Crear elemento <a>
                            const repoLink = document.createElement('a');
                            repoLink.href = `#`;
                            repoLink.classList.add('repo-link', 'd-flex', 'align-items-center');

                            // Crear elemento <img> con la imagen predeterminada
                            const userImage = document.createElement('img');
                            userImage.src = "/img/user_img.png";
                            userImage.alt = user.name;
                            userImage.classList.add('rounded-circle', 'user-avatar');

                            // Crear contenedor de texto
                            const textContainer = document.createElement('div');
                            textContainer.classList.add('user-info');

                            // Crear elemento <span> para el nombre
                            const userName = document.createElement('span');
                            userName.innerText = user.name;
                            userName.classList.add('user-name');

                            // Crear elemento <small> para el nickname
                            const userNick = document.createElement('small');
                            userNick.innerText = user.email + ' * Agregar colaborador';
                            //userNick.classList.add('user-nickname'); Ingresar nickname

                            // Añadir nombre y nickname al contenedor de texto
                            textContainer.appendChild(userName);
                            textContainer.appendChild(userNick);

                            // Añadir imagen y contenedor de texto a <a>
                            repoLink.appendChild(userImage);
                            repoLink.appendChild(textContainer);

                            // Añadir <a> al <li>
                            repoItem.appendChild(repoLink);

                            // Añadir el <li> a resultsDiv
                            resultsDiv.appendChild(repoItem);

                            // Agregar evento de clic para seleccionar el usuario
                            repoItem.addEventListener('click', function () {
                                const userId = repoItem.dataset.userId;
                                const userName = repoItem.dataset.userName;
                                const userEmail = repoItem.dataset.userEmail;

                                selectedUserAvatar.src = userImage.src;
                                selectedUserAvatar.alt = userName;
                                selectedUserName.innerText = userName;
                                selectedUserEmail.innerText = userEmail;

                                selectedUserDiv.style.display = 'flex';
                                addCollaboratorBtn.classList.remove('disabled');
                                addCollaboratorBtn.value = "";
                                addCollaboratorBtn.innerText = "Agregar colaborador al repositorio";
                                addCollaboratorBtn.href = `/collaborators/index/${repoId}/${userId}`;

                                // Limpiar los resultados de búsqueda
                                Array.from(resultsDivs).forEach(resultsDiv => {
                                    resultsDiv.innerHTML = '';
                                });
                                searchLabel.hidden = true;
                                text_search.hidden = true;
                            });
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching users:', error);
                });
        } else {
            Array.from(resultsDivs).forEach(resultsDiv => {
                resultsDiv.innerHTML = ''; // Clear results if query is empty
            });
        }
    });

    // Evento para deseleccionar el usuario
    deselectUserBtn.addEventListener('click', function () {
        selectedUserDiv.style.display = 'none';
        selectedUserAvatar.src = '';
        selectedUserAvatar.alt = '';
        selectedUserName.innerText = '';
        selectedUserEmail.innerText = '';
        addCollaboratorBtn.classList.add('disabled');
        addCollaboratorBtn.href = '#';
        searchLabel.hidden = false;
        searchLabel.value = '';
        text_search.hidden = false;
        addCollaboratorBtn.value = "";
        addCollaboratorBtn.innerText = "Seleccione un colaborador arriba";
    });

    usuariosFinderInput.addEventListener('input', function () {
        const query = usuariosFinderInput.value;
        const repoId = usuariosFinderInput.dataset.repo;
    
        if (query.length > 0) {
            // Ocultar todos los <tr> con la clase 'collaborators'
            collaboratorsRows.forEach(row => {
                row.hidden = true;
            });
    
            fetch(`/search-users?user=${query}&repo=${repoId}&validar=collaborator`)
                .then(response => response.json())
                .then(data => {
                    // Limpiar los resultados anteriores
                    tableBody.querySelectorAll('.generated-row').forEach(row => row.remove());
    
                    data.repositories.forEach(user => {
                        // Crear la estructura HTML
                        const tr = document.createElement('tr');
                        tr.classList.add('collaborators', 'generated-row'); // Añadir clase 'generated-row'
    
                        const td = document.createElement('td');
    
                        const div = document.createElement('div');
                        div.classList.add('d-flex', 'align-items-center', 'justify-content-between');
    
                        const a = document.createElement('a');
                        a.href = '#';
                        a.classList.add('repo-link', 'd-flex', 'align-items-center', 'disabled');
                        a.style.textDecoration = 'none';
                        a.style.cursor = 'default';
    
                        const img = document.createElement('img');
                        img.src = '/img/user_img.png'; // Usar la ruta correcta si estás en la carpeta 'public'
                        img.alt = user.name;
                        img.classList.add('rounded-circle', 'user-avatar');
    
                        const userInfo = document.createElement('div');
                        userInfo.classList.add('user-info');
    
                        const userName = document.createElement('span');
                        userName.classList.add('user-name');
                        userName.innerText = user.name;
    
                        const userDetails = document.createElement('div');
                        userDetails.classList.add('user-details');
    
                        const userEmail = document.createElement('small');
                        userEmail.innerText = user.email + ' ';
    
                        const confirmationStatus = document.createElement('small');
                        if (user.confirmation == 0) {
                            confirmationStatus.style.color = 'rgb(202, 102, 102)';
                            confirmationStatus.innerText = '* Pendiente de confirmación';
                        } else {
                            confirmationStatus.style.color = 'rgb(90, 226, 101)';
                            confirmationStatus.innerText = '* Colaborador';
                        }
    
                        // Añadir confirmationStatus dentro de userEmail
                        userEmail.appendChild(confirmationStatus);
    
                        userDetails.appendChild(userEmail);
    
                        userInfo.appendChild(userName);
                        userInfo.appendChild(userDetails);
    
                        a.appendChild(img);
                        a.appendChild(userInfo);
    
                        const trashIcon = document.createElement('i');
                        trashIcon.classList.add('fa-solid', 'fa-trash', 'icon-delete', 'trash-icon');
                        trashIcon.style.color = 'rgb(216, 101, 101)';
                        trashIcon.style.cursor = 'pointer';
                        trashIcon.dataset.repo = repoId;
                        trashIcon.dataset.user = user.id;
                        trashIcon.dataset.name = user.name;
    
                        div.appendChild(a);
                        div.appendChild(trashIcon);
    
                        td.appendChild(div);
                        tr.appendChild(td);
    
                        tableBody.appendChild(tr);
                    });
    
                    // Agregar eventos de clic a los íconos de eliminación generados
                    document.querySelectorAll('.icon-delete').forEach(function(iconDelete) {
                        // Agregamos un evento de clic a cada ícono
                        iconDelete.addEventListener('click', function () {
                            // Obtenemos los datos del ícono
                            var repo = iconDelete.getAttribute('data-repo');
                            var user = iconDelete.getAttribute('data-user');
                            var name = iconDelete.getAttribute('data-name');
    
                            // Mostramos el Sweet Alert
                            Swal.fire({
                                title: "¿Estás seguro?",
                                html: "<h4 style='color: red'>Una vez lo borres, el usuario " + name + " ya no podrá colaborar con tu repositorio</h4>",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "Sí, borrarlo",
                                cancelButtonText: "No, cancelar",
                                reverseButtons: true,
                                showCloseButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                customClass: {
                                    confirmButton: 'btn btn-success',
                                    cancelButton: 'btn btn-danger'
                                },
                                buttonsStyling: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Redirigimos a la URL con los datos del ícono
                                    window.location.href = "/collaborators/delete/" + repo + "/" + user;
                                }
                            });
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching users:', error);
                });
        } else {
            tableBody.querySelectorAll('.generated-row').forEach(row => row.remove());
            // Mostrar todos los <tr> con la clase 'collaborators' si el input está vacío
            collaboratorsRows.forEach(row => {
                row.hidden = false;
            });
        }
    });

    document.querySelectorAll('.icon-delete').forEach(function(iconDelete) {
        // Agregamos un evento de clic a cada ícono
        iconDelete.addEventListener('click', function () {
            // Obtenemos los datos del ícono
            var repo = iconDelete.getAttribute('data-repo');
            var user = iconDelete.getAttribute('data-user');
            var name = iconDelete.getAttribute('data-name');

            // Mostramos el Sweet Alert
            Swal.fire({
                title: "¿Estás seguro?",
                html: "<h4 style='color: red'>Una vez lo borres, el usuario " + name + " ya no podrá colaborar con tu repositorio</h4>",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, borrarlo",
                cancelButtonText: "No, cancelar",
                reverseButtons: true,
                showCloseButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirigimos a la URL con los datos del ícono
                    window.location.href = "/collaborators/delete/" + repo + "/" + user;
                }
            });
        });
    });
});