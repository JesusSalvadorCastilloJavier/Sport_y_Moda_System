$(document).ready(function() {
    var table=$('#tbl-usuarios').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "scrollX": true
    });
    $('#tbl-usuarios tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
} );

$(document).ready(function() {
    var table=$('#tbl-roles').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "scrollX": true
    });
    $('#tbl-roles tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
    
} );

$(document).ready(function() {
    var table=$('#tbl-colores').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "scrollX": true
    });
    $('#tbl-colores tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
} );

$(document).ready(function() {
    var table=$('#tbl-tallas').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "scrollX": true
    });
    $('#tbl-tallas tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
} );

$(document).ready(function() {
    var table=$('#tbl-marcas').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "scrollX": true
    });
    $('#tbl-marcas tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
} );

$(document).ready(function() {
    var table=$('#tbl-proveedores').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "scrollX": true
    });

    $('#tbl-proveedores tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

} );

$(document).ready(function() {
    var table=$('#tbl-clientes').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "scrollX": true
    });

    $('#tbl-clientes tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

} );


$(document).ready(function() {
    var table=$('#tbl-prendas').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "scrollX": true
    });

    $('#tbl-prendas tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

} );

/*$(document).ready(function() {
    var table=$('#tbl-privilegios').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "scrollX": true
    });

} );*/


$(document).ready(function() {
    var table=$('#tbl-prendas-venta').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "scrollX": true
        ,pageLength : 4,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
    });

    $('#tbl-prendas-venta tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

} );

/*$(document).ready(function() {
    var table=$('#tbl-prendas-carrito').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "scrollX": true
        //,pageLength : 6,
        //lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
    });
    

    $('#tbl-prendas-carrito tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

} );

*/

$(document).ready(function() {
    var table=$('#tbl-prendas-apartado').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "scrollX": true
        ,pageLength : 4,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
    });

    $('#tbl-prendas-apartado').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

} );

$(document).ready(function() {
    var table=$('#tbl-ventas').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "scrollX": true,
        order: [[0, 'desc']],
    });
    $('#tbl-ventas tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
} );

$(document).ready(function() {
    var table=$('#tbl-apartados').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        "scrollX": true,
        order: [[0, 'desc']]
    });
    $('#tbl-apartados tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
} );
