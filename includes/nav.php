<nav class="navbar navbar-main navbar-expand-lg px-2 shadow-none border-radius-xl position-sticky left-auto z-index-sticky" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-3 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    <!-- Add your page ID and Breadcrumb names to this if statement as it grows-->
                    <?php 
                        if($SiteID == '') {
                            echo '';
                        } else if(isset($_GET['pageId']) && $_GET['pageId'] == '<Add your google id here>') {
                            echo 'THE SITES NAME RELATED TO THE ID';
                        }
                    ?>
                </li>
            </ol>
            <h6 class="font-weight-bolder mb-0">Dashboard</h6>
        </nav>
    </div>
</nav>

<script>
    // Add and remove these classes on scroll to the nav, for a nice effect
    $(window).scroll(function () {    
        const scroll = $(window).scrollTop();
        if (scroll >= 50) {
            $('#navbarBlur').addClass('blur shadow-blur top-10');
        } else {
            $('#navbarBlur').removeClass('blur shadow-blur top-10');
        }
    }); 
</script>