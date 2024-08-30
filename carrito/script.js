function limpiar() {
    if (confirm("Estas seguro de que quieres limpiar el carrito?")) {
        $.ajax({
            type: 'POST',
            url: './eliminar.php',
            success: function(result) {
                if (result == 'ok') {
                    location.reload();
                }
                else {
                    alert(result);
                }
            }
        });
    }
}
function eliminar(id) {
    if (confirm("Estas seguro de que quieres eliminar el producto?")) {
        $.ajax({
            type: 'POST',
            url: './eliminar.php',
            data: {
                'id': id
            },
            success: function(result) {
                if (result == 'ok') {
                    location.reload();
                }
                else {
                    alert(result);
                }
            }
        });
    }
}

function facturar() {
    if ($('#tarjeta-facturar').val() && parseInt($('#tarjeta-facturar').val()) > 0) {
        if ($('#direccion-facturar').val()) {
            $.ajax({
                type: 'POST',
                url: 'facturar.php',
                data: {
                    'direccion': $('#direccion-facturar').val(),
                    'tarjeta': parseInt($('#tarjeta-facturar').val())
                },
                success: function(result) {
                    if (result == 'ok') {
                        alert('Gracias por comprar Orgánico CR');
                        location.reload();
                    }
                    else {
                        alert(result);
                    }
                }
            });
        }
        else {
            alert("Por favor agrega una direccion valida");
        }
    }
    else {
        alert("Por favor agrega una tarjeta valida sin espacios");
    }
}

$('#facturarModal').on('shown.bs.modal', function() {
    $(document).off('focusin.modal');
});