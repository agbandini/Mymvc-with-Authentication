<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="/themes/admin/img/user160.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p><?= $this->userFullName ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- search form -->

    <!-- /.search form -->

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">NAVIGAZIONE</li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
            </ul>
        </li>

        

        <li class="header">ADMIN</li>
        <li class="treeview <?= setActive(0, 'users', 'groups') ?>">
            <a href="#">
                <i class="fa fa-users"></i> <span>Utenti</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="<?= setActive(0, 'users') ?>"><a href="/users"><i class="fa fa-circle-o"></i> Gestione Utenti</a></li>
                <li class="<?= setActive(0, 'groups') ?>"><a href="/groups"><i class="fa fa-circle-o"></i> Gestione Gruppi Utente</a></li>

            </ul>            
        </li>        

        <li><a href="/logout"><i class="fa fa-book"></i> <span>Esci</span></a></li>
    </ul>
</section>
<!-- /.sidebar -->