window.addEventListener("DOMContentLoaded", function () {
  console.log(`login client`);

  let $form = document.querySelector("#signin");
  let $msg = document.querySelector(".msg");
  $form.addEventListener("submit", function (e) {
    e.preventDefault();

    let datos = new FormData($form);
    let datosParse = new URLSearchParams(datos);

    fetch(`${plz.rest_url}/login`, {
      method: "POST",
      body: datosParse,
    })
      .then((res) => {
        if (!res.ok) {
          throw new Error("Hubo un problema con la respuesta del servidor.");
        }
        return res.json();
      })
      .then((json) => {
        if (json.msg) {
          $msg.innerHTML = json.msg;
        } else {
          $msg.innerHTML =
            '<div class="p-3 text-primary-emphasis bg-danger-subtle border border-danger-subtle rounded-3">Hubo un problema con la respuesta del servidor.</div>';
        }

        // Si se ha logueado correctamente, redirigir a la página principal
        if (json.msg.includes("correctamente")) {
          $msg.innerHTML =
            '<div class="p-3 text-primary-emphasis bg-success-subtle border border-success-subtle rounded-3">Se ha loggeado correctamente 😎</div>';

          setTimeout(function () {
            // redi al home
            window.location.href = `${plz.home_url}`;
          }, 1000);
        }
      })
      .catch((err) => {
        console.log(`Hubo un error: ${err}`);
        $msg.innerHTML =
          '<div class="p-3 text-primary-emphasis bg-danger-subtle border border-danger-subtle rounded-3">Hubo un problema con la solicitud.</div>';
      });
  });
});
