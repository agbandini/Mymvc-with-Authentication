<?php if (isset($Err) && $Err->has_errors()) { ?>
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Attenzione!</h4>
        <?= $Err->display_errors_html(true); ?>
    </div>
<?php } ?>

<div class="login-box-body">
    <p class="login-box-msg">Effettua l'accesso per iniziare</p>
    <form action="/login/dologin" method="post" id="_lgnFrm">
        <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="email" id="_email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name='password' id="_password">
            <input type="hidden" class="form-control" name="hashpwd" id="_hashpwd" value="">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox"> Ricordami
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat" id="_loginBtn">Accedi</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <!-- /.social-auth-links -->

    <a href="/lostpassword">Ho dimenticato la password</a><br>

</div>