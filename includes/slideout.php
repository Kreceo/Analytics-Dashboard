<div class="fixed-plugin" id="slideOut">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2" id="slideOutButton">
    <i class="bi bi-list"></i>
    </a>
    <div class="card shadow-lg ">
        <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-left ms-3" id="sidenav-main"></aside>
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute right-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <div class="navbar-brand m-0" style="padding: 15px 15px;">
                <img src="./assets/images/froogle-logo.png" class="navbar-brand-img h-100 mb-2 w-100" alt="..."><br>
                <span class="font-weight-bold mb-2">Analytics Dashboard by <br>Darrell Lane</span>
                </a>
            </div>
            <hr class="horizontal dark mt-0">
            <div class="w-auto" id="sidenav-collapse-main">
                <ul class="navbar-nav">
                    <li class="nav-item px-3 py-2 rounded d-flex hover-sidebar-mobile">
                        <a class="nav-link d-flex active align-items-center" href="dashboard.php<?php echo '?pageId=<Add your google id here>'; ?>">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <img src="https://img.icons8.com/dusk/64/000000/edit--v1.png" class="rounded w-100">
                            </div>
                            <span class="nav-link-text ms-1 text-dark">Froogle.com</span>
                        </a>
                    </li>
                    <li class="nav-item px-3 py-2 rounded d-flex hover-sidebar-mobile">
                        <a class="nav-link d-flex align-items-center" href="dashboard.php<?php echo '?pageId=<Add your google id here>'; ?>">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <img src="https://img.icons8.com/dusk/64/000000/edit--v1.png" class="rounded w-100">
                            </div>
                            <span class="nav-link-text ms-1 text-dark">Kreceo.com</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Toggle the show class for hidding and showing the right hand side mobile slide out menu -->
<script>
    $('#slideOutButton').click(function () {
        $('#slideOut').toggleClass('show');
    });
</script>