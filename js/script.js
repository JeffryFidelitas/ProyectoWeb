/*function agregarTarea(tarea, lista) {
    const elementoLi = document.createElement('li');
    elementoLi.textContent = tarea;
    const botonEliminar = document.createElement('button');
    botonEliminar.textContent = 'Eliminar';
    botonEliminar.addEventListener('click', () => {
        lista.removeChild(elementoLi);
    });
    elementoLi.appendChild(botonEliminar);
    lista.appendChild(elementoLi);
}

document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.getElementById('formulario');
    const entrada = document.getElementById('entrada');
    const lista = document.getElementById('lista');

    formulario.addEventListener('submit', function(evento) {
        evento.preventDefault();
        const tarea = entrada.value.trim();
        if (tarea !== '') {
            agregarTarea(tarea, lista);
            entrada.value = '';
        }
    });
}); */


//Añadir header y footer
document.addEventListener("DOMContentLoaded", function() {
    try {
      fetch("header.html")
        .then(response => response.text())
        .then(data => {
          document.getElementById("header-container").innerHTML = data;
        })
        .catch(error => console.error("Error loading header:", error));
    } catch (error) {
      console.error("Error loading header:", error);
    }
  
    try {
      fetch("footer.html")
        .then(response => response.text())
        .then(data => {
          document.getElementById("footer-container").innerHTML = data;
        })
        .catch(error => console.error("Error loading footer:", error));
    } catch (error) {
      console.error("Error loading footer:", error);
    }
  });




// Modales de producto

document.addEventListener('DOMContentLoaded', function() {
    const listaProductos = document.getElementById('listaProductos');
    const formAgregarProducto = document.getElementById('formAgregarProducto');
    const formEditarProducto = document.getElementById('formEditarProducto');

    let productos = [];

    function renderizarProductos() {
        listaProductos.innerHTML = '';
        productos.forEach((producto, indice) => {
            const tarjetaProducto = `
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="https://via.placeholder.com/150" class="card-img-top" alt="${producto.nombre}">
                        <div class="card-body">
                            <h5 class="card-title">${producto.nombre}</h5>
                            <p class="card-text">Proveedor: ${producto.proveedor}</p>
                            <p class="card-text">Descripción: ${producto.descripcion}</p>
                            <p class="card-text">Precio: $${producto.precio}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-primary">Agregar al carrito</button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="editarProducto(${indice})" data-toggle="modal" data-target="#editarProductoModal">Editar</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="eliminarProducto(${indice})">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            listaProductos.innerHTML += tarjetaProducto;
        });
    }

    formAgregarProducto.addEventListener('submit', function(event) {
        event.preventDefault();
        const nuevoProducto = {
            nombre: document.getElementById('nombreProducto').value,
            proveedor: document.getElementById('proveedorProducto').value,
            descripcion: document.getElementById('descripcionProducto').value,
            precio: document.getElementById('precioProducto').value
        };
        productos.push(nuevoProducto);
        renderizarProductos();
        $('#agregarProductoModal').modal('hide');
        formAgregarProducto.reset();
    });

    formEditarProducto.addEventListener('submit', function(event) {
        event.preventDefault();
        const indice = document.getElementById('editarProductoId').value;
        productos[indice] = {
            nombre: document.getElementById('editarNombreProducto').value,
            proveedor: document.getElementById('editarProveedorProducto').value,
            descripcion: document.getElementById('editarDescripcionProducto').value,
            precio: document.getElementById('editarPrecioProducto').value
        };
        renderizarProductos();
        $('#editarProductoModal').modal('hide');
    });

    window.editarProducto = function(indice) {
        document.getElementById('editarProductoId').value = indice;
        document.getElementById('editarNombreProducto').value = productos[indice].nombre;
        document.getElementById('editarProveedorProducto').value = productos[indice].proveedor;
        document.getElementById('editarDescripcionProducto').value = productos[indice].descripcion;
        document.getElementById('editarPrecioProducto').value = productos[indice].precio;
    };

    window.eliminarProducto = function(indice) {
        productos.splice(indice, 1);
        renderizarProductos();
    };

    renderizarProductos();
});






