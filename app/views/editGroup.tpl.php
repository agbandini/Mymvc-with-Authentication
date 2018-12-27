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
        <form id="_editGroup" method="post" enctype="application/x-www-form-urlencoded" action="<?= is_null($group['group_id']) ? '/groups/save' : '/groups/' . $group['group_id'] . '/store' ?>">
            <div class="box-header with-border">
                <h3 class="box-title">CREA/MODIFICA GRUPPO UTENTE: <?= $group['group_name'] ?></h3>
            </div>
            <div class="box-body">
                <input type="hidden" name="group_id" value="<?= is_null($group['group_id']) ? 0 : $group['group_id'] ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="descrizione">Nome Gruppo *</label>
                            <input class="form-control" type="text" name="group_name" id="_nome_gruppo" value="<?= $group['group_name'] ?>" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Descrizione gruppo</label>
                                    <textarea name="group_description" class="form-control" rows="3" placeholder="Descrizione del gruppo..."><?= $group['group_description'] ?></textarea>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-success" >Salva gruppo utente <i id="_icoSalva" class="fa fa-floppy-o"></i></button> 
            </div>
            <!-- /.box-footer-->
        </form>
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->