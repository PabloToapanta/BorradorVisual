$(document).ready(function () {

            // Filtra por texto y por estado al mismo tiempo
            function filtrarTabla() {
                var texto = $("#buscador").val().toLowerCase();
                var estado = $("#filtroEstado").val();

                $("#tablaTarjetas tbody tr").each(function () {
                    var fila = $(this);
                    var datos = fila.find("td:eq(1), td:eq(2)").text().toLowerCase();
                    var estadoFila = fila.find("td:eq(3)").text().trim();

                    var coincideTexto = datos.indexOf(texto) > -1;
                    var coincideEstado = estado === "" || estadoFila === estado;

                    fila.toggle(coincideTexto && coincideEstado);
                });
            }

            $("#buscador").on("keyup", filtrarTabla);
            $("#filtroEstado").on("change", filtrarTabla);

            // Resalta la fila al hacer clic
            $("#tablaTarjetas tbody").on("click", "tr", function () {
                $(this).css("background-color", "#dbeafe")
                       .siblings().css("background-color", "");
            });
        });