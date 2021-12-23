<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-calendar-week"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Absensi-Sk</div>
    </a>

    <?php if (session()->get('level') == 'admin') :
    ?>
        <!-- admin -->
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            User Management
        </div>

        <!-- Nav Item - user list -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>/userlists">
                <i class="fas fa-users"></i>
                <span>User List</span></a>
        </li>

        <!-- Nav Item - Data Guru -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>/admin/dataguru">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Data Guru</span></a>
        </li>

        <!-- Nav Item - Data Kelas -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url(); ?>/admin/datakelas">
                <i class="fas fa-school"></i>
                <span>Data Kelas</span></a>
        </li>
    <?php endif;
    ?>

    <!-- user -->
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        User Profile
    </div>

    <!-- Nav Item - Profil -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>/user">
            <i class="fas fa-user"></i>
            <span>My Profile</span></a>
    </li>

    <!-- Nav Item - Edit Profile -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>/user/edit">
            <i class="fas fa-user-edit"></i>
            <span>Edit Profile</span></a>
    </li>

    <hr class="sidebar-divider">

    <?php if (session()->get('level') == 'user') : ?>
        <!-- Nav Item - Absensi -->
        <div class="sidebar-heading">
            ABSENSI DAN SISWA
        </div>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('absensi'); ?>">
                <i class="fas fa-calendar-alt"></i>
                <span>Absensi</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('cari'); ?>">
                <i class="fas fa-search"></i>
                <span>Cari Data Absen</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('rekap'); ?>">
                <i class="far fa-calendar-check"></i>
                <span>Rekap Absen</span></a>
        </li>

        <hr class="sidebar-divider">
    <?php endif; ?>

    <!-- logout -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url(); ?>/logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>