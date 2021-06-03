<?php 
    // Do not touch this file -- HANDS OFF! -- 
    require 'service-account-analytics.php';

    // Stats Variables
    $userStatsOutput = returnResults($userStats);
    $cUserStatsOutput = returnResults($cUserStats);
    $pageStatsOutput = returnResults($pageStats);
    $topPagesOutput = returnResults($topPages);
    $topEventsOutput = returnResults($topEvents);
    $cPageStatsOutput = returnResults($cPageStats);
    $SiteID = isset($_GET['pageId']) ? $_GET['pageId'] : '<Add your google id here>';
    
    /**
    * Takes in the 2 analytic values
    * Returns them in a span tag with a different class depending on - or +
    */
    function difference($a, $b) {
       if($a > $b) {
          echo '<span class="green"> +' . abs($a - $b) . '</span>';
       } else {
          echo '<span class="red"> -' . abs($a - $b) . '</span>';
       }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/png" href="https://img.icons8.com/dusk/64/000000/edit--v1.png">
        <title>Analytics Dashboard by Darrell Lane</title>

        <!-- Google font -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

        <!-- CSS Files -->
        <link id="pagestyle" href="./assets/css/analytics.css" rel="stylesheet" />

        <!-- Bootstrap files -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" integrity="sha512-xnP2tOaCJnzp2d2IqKFcxuOiVCbuessxM6wuiolT9eeEJCyy0Vhcwa4zQvdrZNVqlqaxXhHqsSV1Ww7T2jSCUQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>

    <body class="g-sidenav-show bg-gray-100">
    
      <!-- Sidebar menu where more sites will be added -->
      <?php include './includes/sidebar.php' ?>

      <main class="main-content mt-1 border-radius-lg">

            <!-- Navbar -->
            <?php include './includes/nav.php' ?>

            <!-- Date picker form ( Includes compare dates ) -->
            <?php include './includes/dateForm.php' ?>

            <!-- Shows chosen dates -->
            <div class="container-fluid dateRange">
                <div class="d-flex align-items-center mb-2">
                    <h6 class="mb-0"><?php echo $startDate .' - ' . $endDate ?></h6>
                    <span class="blue"></span>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <h6 class="mb-0"><?php echo $cStartDate .' - ' . $cEndDate ?></h6>
                    <span class="orange"></span>
                </div>
            </div>

            <!-- This is the main dashboard section containing all the returned data from google analytics repoting api -->
            <section id="dashboardSection">
                <div class="container-fluid pb-3">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mt-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers stats">
                                                <p>Users</p>
                                                <p>
                                                    <?php difference($userStatsOutput[0]['Users'], $cUserStatsOutput[0]['Users']);?>
                                                </p>
                                                <p>
                                                    <span class="blue"><?php echo $userStatsOutput[0]['Users'] ?></span> vs <span class="orange"><?php echo $cUserStatsOutput[0]['Users'] ?></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                <i class="bi bi-binoculars"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mt-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers stats">
                                                <p>New Users</p>
                                                <p>
                                                    <?php difference($userStatsOutput[1]['New Users'], $cUserStatsOutput[1]['New Users']);?>
                                                </p>
                                                <p>
                                                    <span class="blue"><?php echo $userStatsOutput[1]['New Users'] ?></span> vs <span class="orange"><?php echo $cUserStatsOutput[1]['New Users'] ?></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                <i class="bi bi-binoculars"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mt-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers stats">
                                                <p>Page Views</p>
                                                <p>
                                                    <?php difference($pageStatsOutput[0]['Page Views'], $cPageStatsOutput[0]['Page Views']);?>
                                                </p>
                                                <p>
                                                    <span class="blue"><?php echo $pageStatsOutput[0]['Page Views'] ?></span> vs <span class="orange"><?php echo $cPageStatsOutput[0]['Page Views'] ?></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                <i class="bi bi-binoculars"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mt-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers stats">
                                                <p>Unique Page Views</p>
                                                <p>
                                                    <?php difference($pageStatsOutput[1]['Unique Page Views'], $cPageStatsOutput[1]['Unique Page Views']);?>
                                                </p>
                                                <p>
                                                    <span class="blue"><?php echo $pageStatsOutput[1]['Unique Page Views'] ?></span> vs <span class="orange"><?php echo $cPageStatsOutput[1]['Unique Page Views'] ?></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                <i class="bi bi-binoculars"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mt-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers stats">
                                                <p>Avg Session Duration</p>
                                                <p>
                                                    <?php difference(round($userStatsOutput[2]['Avg Session Duration'], 2) , round($cUserStatsOutput[2]['Avg Session Duration'], 2));?>s
                                                </p>
                                                <p>
                                                    <span class="blue"><?php echo round($userStatsOutput[2]['Avg Session Duration'], 2) ?></span> vs <span class="orange"><?php echo round($cUserStatsOutput[2]['Avg Session Duration'], 2) ?></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                <i class="bi bi-binoculars"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mt-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers stats">
                                                <p>Avg Page Views</p>
                                                <p>
                                                    <?php difference(round($userStatsOutput[3]['Avg Page Views'], 2) , round($cUserStatsOutput[3]['Avg Page Views'], 2));?>%
                                                </p>
                                                <p>
                                                    <span class="blue"><?php echo round($userStatsOutput[3]['Avg Page Views'], 2) ?></span> vs <span class="orange"><?php echo round($cUserStatsOutput[3]['Avg Page Views'], 2) ?></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                <i class="bi bi-binoculars"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mt-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers stats">
                                                <p>Avg Page Load</p>
                                                <p>
                                                    <?php difference(round($pageStatsOutput[3]['Page Speed'], 2) , round($cPageStatsOutput[3]['Page Speed'], 2));?>s
                                                </p>
                                                <p>
                                                    <span class="blue"><?php echo round($pageStatsOutput[3]['Page Speed'], 2) ?></span> vs <span class="orange"><?php echo round($cPageStatsOutput[3]['Page Speed'], 2) ?></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                <i class="bi bi-binoculars"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6 mb-xl-0 mt-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers stats">
                                                <p>Avg Bounce Rate</p>
                                                <p>
                                                    <?php difference(round($pageStatsOutput[2]['Bounce Rate'], 2 ) , round($cPageStatsOutput[2]['Bounce Rate'], 2 ));?>%
                                                </p>
                                                <p>
                                                    <span class="blue"><?php echo round($pageStatsOutput[2]['Bounce Rate'], 2 ) ?></span> vs <span class="orange"><?php echo round($cPageStatsOutput[2]['Bounce Rate'], 2 ) ?></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                <i class="bi bi-binoculars"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="mt-4">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6>Top 10 highest-performing pages</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Views</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $i = 1;
                                                    foreach($topPagesOutput[0]['ga:pageTitle'] as $page => $pageviews) {
                                                        echo '<tr><td>' . $i++ . '</td><td>' . $page . '</td><td>' . $pageviews . '</td></tr>';
                                                    }
                                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h6>Top 10 ranking events</h6>
                                </div>
                                <div class="card-body p-3">
                                    <nav>
                                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Category</a>
                                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Action</a>
                                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Label</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <div class="table-responsive">
                                                <table class="table" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Category Name</th>
                                                            <th>Clicks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $i = 1;
                                                            foreach($topEventsOutput[0]['ga:eventCategory'] as $page => $pageviews) {
                                                                echo '<tr><td>' . $i++ . '</td><td>' . $page . '</td><td>' . $pageviews . '</td></tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                            <div class="table-responsive">
                                                <table class="table" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Action Name</th>
                                                            <th>Clicks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $i = 1;
                                                            foreach($topEventsOutput[1]['ga:eventAction'] as $page => $pageviews) {
                                                                echo '<tr><td>' . $i++ . '</td><td>' . $page . '</td><td>' . $pageviews . '</td></tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                            <div class="table-responsive">
                                                <table class="table" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Label Name</th>
                                                            <th>Clicks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            $i = 1;
                                                            foreach($topEventsOutput[2]['ga:eventLabel'] as $page => $pageviews) {
                                                                echo '<tr><td>' . $i++ . '</td><td>' . $page . '</td><td>' . $pageviews . '</td></tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            
                <!-- Footer include -->
                <?php include './includes/footer.php' ?>

            </section>
         </main>

         <!--  This is the slide out menu, which is mainly for mobile -->
         <?php include './includes/slideout.php' ?>

      <!-- JS for analytics dashboard -->
      <script src="./assets/js/analytics.js"></script>
   </body>
</html>