<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="./index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Master Data</div>
                <a class="nav-link" href="./roti.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-bread-slice"></i></div>
                    Roti
                </a>
                <a class="nav-link" href="./user.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    User
                </a>
                <div class="sb-sidenav-menu-heading">Pesanan</div>
                <a class="nav-link" href="./pesanan.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Pesanan
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <p class="text-white fw-bold mb-0"><?php echo $_SESSION['username_admin'] ?></p>
        </div>
    </nav>
</div>