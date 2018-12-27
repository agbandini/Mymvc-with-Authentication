$(document).ready(function () {
    cercaPopola('');
});

function cercaPopola(daCercare) {
    var table = $('#_gruppi_utente').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 25,
        "searching": true,
        "language": {
            "url": "/themes/admin/plugins/datatables/italian.json"
        },
        "ajax": {
            "url": "/groups/all",
            "type": "POST",
            "data": {
                'term': daCercare
            }
        },
        "columns": [
            {"data": "nome_gruppo", "name": "group_name"},
            {"data": "descrizione", "name": "group_description"},
            {"data": "gestione", "orderable": false, "className": "text-center"}
        ]
    })
}



