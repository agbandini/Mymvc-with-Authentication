<?php if (isset($Err) && $Err->has_errors()) { ?>
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Attenzione!</h4>
        <?= $Err->display_errors_html(true); ?>
    </div>
<?php } ?>

<div class="login-box-body">
    <h3 class="login-box-msg">Password dimenticata</h3>
    <p class="login-box-msg">Inserisci l'indirizzo email che utilizzi per l'accesso, ti verrà inviata una nuova password.</p>
    <form action="/login/pwdremind" method="post" >
        <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="email" id="_email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <button type="submit" id="_confermaBtn" class="btn btn-primary btn-block btn-flat">Conferma  <i id="_icoLogin" class="fa fa-send-o"></i></button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <div class="social-auth-links text-center">
        <p>- ~ -</p>
    </div>
    <!-- /.social-auth-links -->

</div>