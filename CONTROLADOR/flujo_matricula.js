let seleccionados = [];
let cursosMatriculadosActuales = 0;
let cursosMatriculados = [];
let yaMostroAdvertenciaPaso1 = false;

function iniciarFlujoMatricula() {
  const nombre = document.body.dataset.nombre || "";

  fetch('cursos.php')
    .then(res => res.json())
    .then(data => {
      cursosMatriculados = data.matriculados || [];
      cursosMatriculadosActuales = cursosMatriculados.length;

      if (cursosMatriculadosActuales >= 5) {
        mostrarResumen();
      } else {
        mostrarCursosPorCategoria(data.todos, nombre);

        if (!yaMostroAdvertenciaPaso1) {
        const restantes = 5 - cursosMatriculadosActuales;
        alert(`Puedes matricularte en hasta ${restantes === 5 ? 5 : restantes} curso${restantes > 1 ? 's' : ''}.`);
        yaMostroAdvertenciaPaso1 = true;
        }
      }
    })
    .catch(err => mostrarError("No se pudieron cargar los cursos"));
}


function mostrarCursosPorCategoria(cursos, nombre) {
  const nombreAlumno = nombre || document.body.dataset.nombre || "";

   // ⚠️ Mostrar alerta SOLO la primera vez
  if (!sessionStorage.getItem("alertaMatriculaMostrada")) {
    alert("Puedes matricularte en hasta 5 cursos.");
    sessionStorage.setItem("alertaMatriculaMostrada", "true");
  } else {
    const cursosDisponibles = 5 - cursosMatriculadosActuales;
    if (cursosDisponibles > 0) {
      mostrarMensajeInformativo(`Puedes matricularte en ${cursosDisponibles} curso${cursosDisponibles > 1 ? 's' : ''} más.`);
    }
  }
  let html = `
    <div class="paso-barra">
      <div class="paso activo">1</div>
      <div class="paso">2</div>
      <div class="paso">3</div>
    </div>
    <h2 class="paso-titulo">Selecciona tus cursos, ${nombreAlumno}</h2>
  `;

  const agrupado = {};
  cursos.forEach(c => {
    if (!agrupado[c.categoria]) agrupado[c.categoria] = [];
    agrupado[c.categoria].push(c);
  });

  Object.keys(agrupado).forEach(categoria => {
    html += `<div class="categoria-bloque">
      <h3 class="categoria-titulo">${categoria}</h3>
      <div class="cursos-grid">`;

    agrupado[categoria].forEach(curso => {
  const yaMatriculado = cursosMatriculados.some(m => m.id == curso.id);
  const deshabilitado = yaMatriculado ? 'disabled' : '';
  const claseExtra = yaMatriculado ? 'curso-card-matriculado' : '';
  const etiquetaMatriculado = yaMatriculado ? `<span class="etiqueta-matriculado">✅ Ya matriculado</span>` : '';

  html += `
    <div class="curso-card ${claseExtra}" id="curso-card-${curso.id}">
      <h3 class="curso-nombre">${curso.nombre}</h3>
      <p><strong>Días:</strong> ${curso.dias}</p>
      <p><strong>Inicio:</strong> ${curso.fecha_inicio}</p>
      <p><strong>Horario:</strong> ${curso.horario}</p>
      ${etiquetaMatriculado}
      <label>
        <input type="checkbox" class="check-curso" data-id="${curso.id}" ${deshabilitado}
          onchange="seleccionarCurso(${curso.id}, '${curso.nombre}', '${curso.dias}', '${curso.fecha_inicio}', '${curso.horario}', this.checked)" />
        Seleccionar curso
      </label>
      <label>
        <input type="checkbox" id="cert-${curso.id}" ${deshabilitado} /> Deseo certificado
      </label>
    </div>
  `;
});
    html += `</div></div>`;
  });

  html += `
    <button class="fixed-bottom-btn" onclick="confirmarSeleccion()">Siguiente</button>
  `;

  document.getElementById("contenido-principal").innerHTML = html;
}


function seleccionarCurso(id, nombre, dias, fecha, horario, checked) {
  const cert = document.getElementById(`cert-${id}`);
  const card = document.getElementById(`curso-card-${id}`);

  if (checked) {
    const totalIntentados = seleccionados.length + cursosMatriculadosActuales;

    if (totalIntentados >= 5) {
      alert("Ya alcanzaste el máximo de 5 cursos permitidos.");
      document.querySelector(`input[data-id='${id}']`).checked = false;
      return;
    }

    if (seleccionados.length === 0) {
      const restantes = 5 - cursosMatriculadosActuales;
      alert(`Puedes matricularte en hasta ${restantes} curso${restantes > 1 ? 's' : ''}.`);
    }

    seleccionados.push({ id, nombre, dias, fecha, horario, certificado: cert.checked });

    cert.addEventListener('change', () => {
      const idx = seleccionados.findIndex(c => c.id === id);
      if (idx !== -1) {
        seleccionados[idx].certificado = cert.checked;
      }
    });

    if (card) card.classList.add("curso-card-seleccionado");

  } else {
    seleccionados = seleccionados.filter(c => c.id !== id);
    if (card) card.classList.remove("curso-card-seleccionado");
  }
}



function confirmarSeleccion() {
  if (seleccionados.length === 0) {
    alert("Debes seleccionar al menos un curso.");
    return;
  }

  let html = `
    <div class="paso-barra">
      <div class="paso">1</div>
      <div class="paso activo">2</div>
      <div class="paso">3</div>
    </div>

    <div class="barra-superior">
      <button class="btn-regresar" onclick="iniciarFlujoMatricula()">← Regresar</button>
      <button class="btn-siguiente-superior" id="btn-ver-resumen" onclick="mostrarResumen()" style="display: none;">Siguiente</button>
    </div>

    <h2 class="paso-titulo">Detalle del curso</h2>
    <h2>2. Confirmación de cursos seleccionados</h2>

    <div class="tabla-wrapper">
      <table class="tabla-confirmacion">
        <thead>
          <tr>
            <th>Curso</th>
            <th>Días</th>
            <th>Inicio</th>
            <th>Horario</th>
            <th>Certificado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
  `;

  // Filtrar para no mostrar cursos ya matriculados
  const seleccionadosSinMatriculados = seleccionados.filter(sel =>
    !cursosMatriculados.some(m => m.id === sel.id)
  );

  seleccionadosSinMatriculados.forEach(c => {
    html += `
      <tr>
        <td>${c.nombre}</td>
        <td>${c.dias}</td>
        <td>${c.fecha}</td>
        <td>${c.horario}</td>
        <td>${c.certificado ? 'Sí' : 'No'}</td>
        <td id="acciones-${c.id}">
          <button class="btn-eliminar" onclick="eliminarCurso(${c.id})">Eliminar</button>
          <button class="btn-matricular-individual" onclick="matricularCursoUnico(${c.id})">Matricular</button>
        </td>
      </tr>
    `;
  });

  html += `
        </tbody>
      </table>
    </div>

    <button class="btn btn-matricular-final" onclick="matricularCursos()">Matricular Todos</button>
  `;

  document.getElementById("contenido-principal").innerHTML = html;

  // Mostrar botón "Siguiente" si ya hay algún curso matriculado
  if (cursosMatriculados.length + seleccionadosSinMatriculados.length > 0) {
    document.getElementById("btn-ver-resumen").style.display = "inline-block";
  }
}


function eliminarCurso(id) {
  seleccionados = seleccionados.filter(c => c.id !== id);
  confirmarSeleccion();
}

function matricularCursos() {
  if (seleccionados.length + cursosMatriculadosActuales > 5) {
    alert("Has superado el máximo de 5 cursos. Elige menos cursos.");
    return;
  }

  fetch('confirmar_matricula.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(seleccionados)
  })
    .then(res => res.json())
    .then(data => {
  if (data.estado === 'ok') {
    // Pintar todos los seleccionados como matriculados
    seleccionados.forEach(c => {
      const card = document.getElementById(`card-${c.id}`);
      if (card) {
        card.classList.remove('seleccionado');
        card.classList.add('matriculado');
      }
    });

    mostrarResumen();
  } else {
    alert("Hubo un error al registrar la matrícula.");
  }
});
}

function matricularCursoUnico(id) {
  const curso = seleccionados.find(c => c.id === id);
  if (!curso) return;

  fetch('confirmar_matricula.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify([curso])
  })
  .then(res => res.json())
  .then(data => {
    if (data.estado === 'ok') {
      // Marcar visualmente como matriculado
      const fila = document.getElementById(`fila-${id}`);
      const acciones = document.getElementById(`acciones-${id}`);

      if (acciones) {
        acciones.innerHTML = `<span class="matriculado-label">Matriculado</span>`;
      }

      if (fila) {
        fila.classList.add('matriculado-row');
      }

      // Agregar a cursosMatriculados global para evitar duplicación
      cursosMatriculados.push({ id: curso.id, nombre: curso.nombre });

      // Mostrar botón "Siguiente" si aún no se muestra
      const btnResumen = document.getElementById("btn-ver-resumen");
      if (btnResumen && btnResumen.style.display === "none") {
        btnResumen.style.display = "inline-block";
      }

      // Eliminar curso de `seleccionados` y actualizar paso 2
      seleccionados = seleccionados.filter(c => c.id !== id);
      confirmarSeleccion();
    } else {
      alert("Este curso ya fue matriculado o hubo un error.");
    }
  });
}


function mostrarResumen() {
  fetch('detalle_matricula.php')
    .then(res => res.text())
    .then(html => {
      // Buscar filas <tr> dentro del cuerpo de la tabla
      const cantidadCursos = (html.match(/<tr>/g) || []).length - 1; // restamos 1 por el encabezado

      let contenido = `
        <div class="paso-barra">
          <div class="paso">1</div>
          <div class="paso">2</div>
          <div class="paso activo">3</div>
        </div>
      `;

      // Mostrar botón regresar si hay menos de 5 cursos
      if (cantidadCursos < 5) {
        contenido += `<button class="btn-regresar" onclick="iniciarFlujoMatricula()">← Regresar</button>`;
      }

      contenido += `
        <h2 class="paso-titulo">Detalle de matrícula</h2>
        <h2>3. Matrícula Finalizada</h2>
        ${html}
      `;

      document.getElementById("contenido-principal").innerHTML = contenido;
    });
}

function mostrarError(msg) {
  document.getElementById("contenido-principal").innerHTML = `<p style='color:red;'>${msg}</p>`;
}

function mostrarMensajeInformativo(texto) {
  const contenedor = document.getElementById("mensaje-info-matricula");
  if (contenedor) {
    contenedor.innerHTML = `<div class="aviso-matricula">${texto}</div>`;
  }
}

