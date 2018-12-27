<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Gestione Utenti
        <small><?= \Conf::CFG_APP_TITLE ?></small>
    </h1>
</section>
<?php include('./layout/includes/errors.tpl.php'); ?>
<!-- Main content -->
<section class="content">      
    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Inserisci, Modifica o Cancella Utenti</h3>
        </div>
        <div class="box-body">
            <table id="_utenti" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th width="20%">Nominativo</th>
                        <th width="20%">Email</th>
                        <th width="10%">Gruppo</th>
                        <th width="5%" class="text-center">Stato</th>
                        <th width="10%" class="text-center">Mail verificata</th>
                        <th width="10%" class="text-center">Gestione</th>                        
                    </tr>
                </thead>
            </table>  
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <a href="/users/new" class="btn btn-success">Nuovo utente</a>
        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->
<?php include('./layout/modals/confirmation.tpl.php'); ?>
<?php include('./layout/modals/information.tpl.php'); ?>