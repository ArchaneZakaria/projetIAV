<html>
    <head>
        <style>
            span {
                font-weight: bold;
                color: #447a05;
            }
        </style>
    </head>
    <body>
        <span>Type de demande : </span><?= $type_dmd ?><br/><br/>
        <span>Demandé par : </span><?= $user_name ?><br/><br/>
        <span>Type d'utilisateur : </span><?= $type ?><br/><br/>
        <span>Date : </span><?= date('d-m-Y') ?><br/><br/>
        <span>Détail de la demande d'attestation : </span><br>
        <?= $message ?>
    </body>
</html>

