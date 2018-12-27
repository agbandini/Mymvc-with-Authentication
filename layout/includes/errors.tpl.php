<?php if (isset($Err) && $Err->has_errors()) { ?>
    <section class="content minHnull">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> Attenzione!</h4>
                    <?= $Err->display_errors_html(true); ?>
                </div>  
            </div>
        </div>
    </section>
<?php } ?>