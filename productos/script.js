function agregar_al_carrito(el) {
    let elemento_cantidad = $($(el).parent().parent()).find('form input[name="cantidad"]');
    let id = $($(el).parent().parent()).find('form input[name="id_producto"]').val();
    if (elemento_cantidad.val() && parseInt(elemento_cantidad.val()) > 0) {
        $.ajax({
            type: 'POST',
            url: './agregar_al_carrito.php',
            data: {
                'id': id,
                'cantidad': parseInt(elemento_cantidad.val())
            },
            success: function(result) {
                if (result == 'ok') {
                    elemento_cantidad.val('');
                    alert('Producto agregado al carrito!');
                }
                else {
                    alert(result);
                }
            }
        });
    }
    else {
        alert("Por favor agrega una cantidad (kg) valida");
    }
}