document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formgastos");

    form.addEventListener("submit", function (e) {
        // Si estás validando campos, podrías hacerlo aquí
        // Pero por ahora simplemente dejamos pasar el submit
        // Puedes mostrar una alerta opcional si quieres:
        // alert("Enviando gasto...");

        // Si existiera el input hidden 'detalle', lo dejamos vacío por ahora
        let inputDetalle = document.getElementById("detalle");
        if (inputDetalle) {
            inputDetalle.value = "[]"; // o eliminar esta línea si no usas el campo
        }

        // Dejas que el form se envíe normalmente (al archivo forgastos.php)
    });
});
