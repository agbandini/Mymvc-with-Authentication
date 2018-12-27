<!DOCTYPE html>
<html>
    <head>
        <?php include('includes/css.tpl.php'); ?>
        <?= $this->customcss ?>
    </head>
    <body class="hold-transition <?= \Conf::CFG_SKIN ?> sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">

            <header class="main-header">
                <?php include('includes/topbar.tpl.php'); ?>
            </header>

            <!-- =============================================== -->

            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar">
                <?php include('includes/menu.tpl.php'); ?>
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <?= $this->content ?>
            </div>
            <!-- /.content-wrapper -->
            <?php include('includes/footer.tpl.php'); ?>
        </div>
        <!-- ./wrapper -->
        <?php include('includes/js.tpl.php'); ?>
        <?= $this->customjs ?>
    </body>
</html>
