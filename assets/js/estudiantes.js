$(document).ready(function () {
    $("#buscador").on("input", function () {
        var texto = $(this).val().trim().toLowerCase();

        $("#tablaEstudiantes tbody tr").each(function () {
            var fila = $(this);
            var datos = fila.find("td:eq(1), td:eq(2), td:eq(3)").text().toLowerCase();
            fila.toggle(datos.indexOf(texto) > -1);
        });
    });
});
