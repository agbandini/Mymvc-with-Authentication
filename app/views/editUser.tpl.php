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
        <form id="_editUser" method="post" enctype="application/x-www-form-urlencoded" action="<?= is_null($user['user_id']) ? '/users/save' : '/users/' . $user['user_id'] . '/store' ?>">
            <div class="box-header with-border">
                <h3 class="box-title">CREA/MODIFICA PROFILO UTENTE: <?= $user['ragione_sociale'] . ' - ' . $user['cognome'] . ' ' . $user['nome'] ?></h3>
            </div>
            <div class="box-body">
                <input type="hidden" id="_user_id" name="user_id" value="<?= is_null($user['user_id']) ? 0 : $user['user_id'] ?>">
                <input type="hidden" name="profile_id" value="<?= is_null($user['profile_id']) ? 0 : $user['profile_id'] ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nome">Email *</label>
                            <input class="form-control" type="text" name="email" size="50" value="<?= $user['user_email'] ?>" />
                            <input type="hidden" name="old_email" value="<?= $user['user_email'] ?>" />
                        </div>
                        <div class="form-group">
                            <label for="descrizione">Password *</label>
                            <input type="hidden" name="old_password" value="<?= $user['user_password'] ?>" />
                            <input class="form-control" type="password" name="password" id="_password" size="50" />
                        </div>
                        <div class="form-group">
                            <label for="descrizione">Conferma Password *</label>
                            <input class="form-control" type="password" name="confirm_password" size="50" />
                        </div>
                        <div class="form-group">
                            <label>Gruppo utente</label>
                            <input type="hidden" name="gruppo_old" value="<?= $user['group_id'] ?>">
                            <select class="form-control select2" name="gruppo_utente" id="_gruppo_utente" Title="Gruppo utente">
                                <?php foreach ($groups as $gr) { ?>
                                    <option value="<?= $gr['group_id'] ?>" <?php if ($user['group_id'] == $gr['group_id']) echo "selected"; ?>><?= $gr['group_name'] ?></option>
                                <?php } ?>    
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Stato</label>
                            <select class="form-control select2" name="stato" id="_stato" Title="Stato">
                                <option value="0" <?php if ($user['user_status'] == "0") echo "selected"; ?>>Non Attivo</option>
                                <option value="1" <?php if ($user['user_status'] == "1") echo "selected"; ?>>Attivo</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Email verificata</label>
                            <select class="form-control select2" name="mail_verificata" id="_mail_verificata" Title="Email verificata">
                                <option value="0" <?php if ($user['user_approved'] == "0") echo "selected"; ?>>No</option>
                                <option value="1" <?php if ($user['user_approved'] == "1") echo "selected"; ?>>Si</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Anagrafica</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cognome *</label>
                                                <input class="form-control" type="text" name="cognome"  value="<?= $user['cognome'] ?>" />
                                            </div>					
                                        </div>                                                          
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nome *</label>
                                                <input class="form-control" type="text" name="nome" value="<?= $user['nome'] ?>" />
                                            </div>                                                        
                                        </div>
                                        <div class="col-md-4">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Telefono</label>
                                                <input class="form-control" type="text" name="telefono" size="50" value="<?= $user['telefono'] ?>" />
                                            </div>					
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cellulare *</label>
                                                <input class="form-control" type="text" name="cellulare" size="50" value="<?= $user['cellulare'] ?>" />
                                            </div>					
                                        </div>

                                    </div>
                                    <hr>
                                </div>
                            </div>
                            <!-- /.tab-content -->
                        </div>                                    
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-success" >Salva profilo utente <i id="_icoSalva" class="fa fa-floppy-o"></i></button> 
            </div>
            <!-- /.box-footer-->
        </form>
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->