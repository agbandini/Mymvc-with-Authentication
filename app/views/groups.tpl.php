<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Gestione Gruppi Utente
        <small><?= \Conf::CFG_APP_TITLE ?></small>
    </h1>
</section>
<?php include('./layout/includes/errors.tpl.php'); ?>
<!-- Main content -->
<section class="content">      
    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Inserisci, Modifica o Cancella Gruppi Utente</h3>
        </div>
        <div class="box-body">
            <table id="_gruppi_utente" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="30%">Nome gruppo</th>
                        <th width="40%">Descrizione</th>
                        <th width="10%">Gestione</th>
                    </tr>
                </thead>
            </table>  
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <a href="/groups/new" class="btn btn-success">Nuovo gruppo</a>
        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->
<?php include('./layout/modals/confirmation.tpl.php'); ?>
<?php include('./layout/modals/information.tpl.php'); ?>