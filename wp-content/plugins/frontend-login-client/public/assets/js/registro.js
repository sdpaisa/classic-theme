window.addEventListener("DOMContentLoaded", function () {
  console.log("registro cargado"); // Debugear si el registro fue cargado
  let $form = document.querySelector("#signup");
  let $msg = document.querySelector(".msg");

  $form.addEventListener("submit", function (e) {
    e.preventDefault();

    let datos = new FormData($form);
    let datosParse = new URLSearchParams(datos); // Parsear datos

    // fetch configurado para devolver un JSON (mensaje al consultar)
    fetch(
      `${plz.rest_url}/registro`, // Ruta estática por lo pronto
      {
        method: "POST",
        body: datosParse,
      }
    )
      .then((res) => res.json())
      .then((json) => {
        console.log(json);
        $msg.innerHTML = `<div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3">${json?.msg}</div>`;
      })
      .catch((err) => {
        // Catch (error personalizado)
        console.log(`Hay un error: ${err}`);
      });
  });
});
