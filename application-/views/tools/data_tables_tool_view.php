<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script type="text/javascript" charset="utf8" src="<?php echo base_url('assets'); ?>/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets'); ?>/js/dataTables.bootstrap.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#data-table').DataTable({
        /* Disable initial sort */
        "aaSorting": [],
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [-1] /* 1st one, start by the right */
        }, {
            'bSortable': false,
            'aTargets': [0]
        }],
        language: {
            processing: "Traitement en cours...",
            search: "Rechercher&nbsp;:",
            lengthMenu: "Afficher _MENU_ &eacute;l&eacute;ments",
            info: "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            infoEmpty: "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            infoPostFix: "",
            loadingRecords: "Chargement en cours...",
            zeroRecords: "Aucun &eacute;l&eacute;ment &agrave; afficher",
            emptyTable: "Aucune donnée disponible dans le tableau",
            paginate: {
                first: "Premier",
                previous: "Pr&eacute;c&eacute;dent",
                next: "Suivant",
                last: "Dernier"
            },
            aria: {
                sortAscending: ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        }
    });
} );
</script>