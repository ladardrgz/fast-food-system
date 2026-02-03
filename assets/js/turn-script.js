const menu = [
  { nombre: "Empanadas criollas", categoria: "entradas", descripcion: "Carne cortada a cuchillo, aceitunas", precio: 1200 },
  { nombre: "Ensalada César", categoria: "entradas", descripcion: "Lechuga, pollo, croutons y salsa César", precio: 1500 },
  { nombre: "Milanesa con papas", categoria: "platos", descripcion: "Clásica milanesa con papas fritas", precio: 2500 },
  { nombre: "Salmón grillado", categoria: "platos", descripcion: "Con puré de papas y salsa de limón", precio: 3200 },
  { nombre: "Flan casero", categoria: "postres", descripcion: "Con dulce de leche y crema", precio: 900 },
  { nombre: "Helado artesanal", categoria: "postres", descripcion: "Sabores varios", precio: 700 },
  { nombre: "Agua sin gas", categoria: "bebidas", descripcion: "Botella 500ml", precio: 500 },
  { nombre: "Cerveza artesanal", categoria: "bebidas", descripcion: "Rubia o negra", precio: 800 }
];

function crearPaginaHTML(titulo, items) {
  let html = `
    <div class="page">
      <h2>${titulo}</h2>
      <ul>
  `;

  for (const item of items) {
    html += `
      <li>
        <span class="name">${item.nombre}</span>
        <span class="price">$${item.precio}</span>
        <small>${item.descripcion}</small>
      </li>
    `;
  }

  html += `</ul></div>`;
  return html;
}

document.addEventListener("DOMContentLoaded", () => {
  const categorias = ["entradas", "platos", "postres", "bebidas"];
  const flipbook = document.getElementById("flipbook");

  for (const cat of categorias) {
    const itemsCat = menu.filter(item => item.categoria === cat);
    const titulo = cat.charAt(0).toUpperCase() + cat.slice(1);
    flipbook.insertAdjacentHTML("beforeend", crearPaginaHTML(`🍽 ${titulo}`, itemsCat));
  }
});
