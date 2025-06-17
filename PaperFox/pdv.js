document.addEventListener('DOMContentLoaded', () => {
  const tabla = document.getElementById('tablaProductos').getElementsByTagName('tbody')[0];
  const btnAñadir = document.getElementById('btnAñadir');
  const btnBorrar = document.getElementById('btnBorrar');
  const btnBuscar = document.getElementById('btnBuscar');
  const buscarInput = document.getElementById('buscarInput');

  const modalEditarEl = document.getElementById('modalEditar');
  const modalEditar = new bootstrap.Modal(modalEditarEl);
  const formEditar = document.getElementById('formEditar');

  const inputID = document.getElementById('inputID');
  const inputNombre = document.getElementById('inputNombre');
  const inputCategoria = document.getElementById('inputCategoria');
  const inputPrecio = document.getElementById('inputPrecio');
  const indexFilaInput = document.getElementById('indexFila');

  let filaSeleccionada = null;

  // Actualiza eventos de botones "Editar"
  function actualizarBotonesEditar() {
    const botones = document.querySelectorAll('.btnEditar');
    botones.forEach((btn, index) => {
      btn.onclick = () => {
        if (filaSeleccionada) {
          filaSeleccionada.classList.remove('fila-seleccionada');
        }
        filaSeleccionada = btn.closest('tr');
        filaSeleccionada.classList.add('fila-seleccionada');

        // Cargar datos al formulario
        indexFilaInput.value = index;
        inputID.value = filaSeleccionada.cells[1].textContent;
        inputNombre.value = filaSeleccionada.cells[2].textContent;
        inputCategoria.value = filaSeleccionada.cells[3].textContent;
        inputPrecio.value = filaSeleccionada.cells[4].textContent.replace('$', '');

        modalEditar.show();
      };
    });
  }

  actualizarBotonesEditar();

  btnAñadir.addEventListener('click', () => {
    const id = prompt("Ingrese ID del producto:");
    const nombre = prompt("Ingrese nombre del producto:");
    const categoria = prompt("Ingrese categoría del producto:");
    const precio = prompt("Ingrese precio del producto:");

    if (id && nombre && categoria && precio) {
      const nuevaFila = tabla.insertRow();
      nuevaFila.classList.add('animate__animated', 'animate__fadeIn');

      const celEditar = nuevaFila.insertCell(0);
      const celID = nuevaFila.insertCell(1);
      const celNombre = nuevaFila.insertCell(2);
      const celCategoria = nuevaFila.insertCell(3);
      const celPrecio = nuevaFila.insertCell(4);

      celEditar.innerHTML = '<button class="btn btn-outline-warning btn-sm btnEditar">Editar</button>';
      celID.textContent = id;
      celNombre.textContent = nombre;
      celCategoria.textContent = categoria;
      celPrecio.textContent = `$${parseFloat(precio).toFixed(2)}`;

      actualizarBotonesEditar();
    } else {
      alert('Datos incompletos. Producto no añadido.');
    }
  });

  btnBorrar.addEventListener('click', () => {
    if (filaSeleccionada) {
      filaSeleccionada.classList.remove('animate__fadeIn');
      filaSeleccionada.classList.add('animate__fadeOut');

      filaSeleccionada.addEventListener('animationend', () => {
        filaSeleccionada.remove();
        filaSeleccionada = null;
      }, { once: true });
    } else {
      alert('Seleccione un producto para borrar.');
    }
  });

  btnBuscar.addEventListener('click', () => {
    const filtro = buscarInput.value.toLowerCase();
    for (let fila of tabla.rows) {
      const nombre = fila.cells[2].textContent.toLowerCase();
      if (nombre.includes(filtro)) {
        fila.style.display = '';
        fila.classList.add('animate__animated', 'animate__flash');
        fila.addEventListener('animationend', () => {
          fila.classList.remove('animate__animated', 'animate__flash');
        }, { once: true });
      } else {
        fila.style.display = 'none';
      }
    }
  });

  formEditar.addEventListener('submit', (e) => {
    e.preventDefault();

    if (!filaSeleccionada) {
      alert('No hay fila seleccionada para editar.');
      modalEditar.hide();
      return;
    }

    filaSeleccionada.cells[1].textContent = inputID.value.trim();
    filaSeleccionada.cells[2].textContent = inputNombre.value.trim();
    filaSeleccionada.cells[3].textContent = inputCategoria.value.trim();
    filaSeleccionada.cells[4].textContent = `$${parseFloat(inputPrecio.value).toFixed(2)}`;

    modalEditar.hide();
  });
});
