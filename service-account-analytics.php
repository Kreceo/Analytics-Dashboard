<?php

// Load the Google API PHP Client Library.
require_once __DIR__ . '/vendor/autoload.php';

// Initialize the analytics model
$analytics = initializeAnalytics();

/**
 * Create a form to this $_GET, and on return, use Ajax to update the data
 * returned to the page, i.e. date range and site id
 */
$SiteID = $_GET['pageId'] ?? '<Add your google id here>';
$startDate = $_GET['start'] ?? '2021-04-26';
$endDate = $_GET['end'] ?? 'today';

$cStartDate = isset($_GET['cStart']) ? $_GET['cStart'] : '2021-03-26';
$cEndDate = isset($_GET['cEnd']) ? $_GET['cEnd'] : '2021-04-25';

// User stats include: ( Users / Unique Users / AVG Time on page, Page views per session )
$userStats = userStats($analytics, $startDate, $endDate, $SiteID);
$cUserStats = cUserStats($analytics, $cStartDate, $cEndDate, $SiteID);

// Page stats include: ( Traffic / Unique Traffic / Bounce Rate / Page Speed )
$pageStats = pageStats($analytics, $startDate, $endDate, $SiteID);
$cPageStats = pageStats($analytics, $cStartDate, $cEndDate, $SiteID);

// Top 10 best performing pages
$topPages = topPages($analytics, $startDate, $endDate, $SiteID);

// Top 10 ranking events
$topEvents = topEvents($analytics, $startDate, $endDate, $SiteID);


/**
 * Initializes an Analytics Reporting API V4 service object.
 *
 * @return An authorized Analytics Reporting API V4 service object.
 */
function initializeAnalytics()
{

  // Use the developers console and download your service account
  // credentials in JSON format. Place them in this directory or
  // change the key file location if necessary.
  $KEY_FILE_LOCATION = __DIR__ . '/service-account-credentials.json'; // <-- These details need to be generated for each site added to dashboard

  // Create and configure a new client object.
  $client = new Google_Client();
  $client->setApplicationName("Analytics Dashboard by Darrell Lane");
  $client->setAuthConfig($KEY_FILE_LOCATION);
  $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
  $analytics = new Google_Service_AnalyticsReporting($client);

  return $analytics;
}

// Page stats ( Page views and unique views )
function pageStats($analytics, $startDate, $endDate, $SiteID) 
{
  // Site ID for pulling in correct site data
  $VIEW_ID = $SiteID;

  // Request object for Users
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate($startDate);
  $dateRange->setEndDate($endDate);

  // Metrics forUnique Page Views
  $UniquePageViewsMetrics = new Google_Service_AnalyticsReporting_Metric();
  $UniquePageViewsMetrics->setExpression("ga:uniquePageViews");
  $UniquePageViewsMetrics->setAlias("Unique Page Views");

  // Request object for Unique Page Views
  $UniquePageViews = new Google_Service_AnalyticsReporting_ReportRequest();
  $UniquePageViews->setViewId($VIEW_ID);
  $UniquePageViews->setDateRanges($dateRange);
  $UniquePageViews->setMetrics(array($UniquePageViewsMetrics));

  // Metrics for Page Views
  $pageViewsMetrics = new Google_Service_AnalyticsReporting_Metric();
  $pageViewsMetrics->setExpression("ga:pageViews");
  $pageViewsMetrics->setAlias("Page Views");

  // Request object for Page Views
  $pageViews = new Google_Service_AnalyticsReporting_ReportRequest();
  $pageViews->setViewId($VIEW_ID);
  $pageViews->setDateRanges($dateRange);
  $pageViews->setMetrics(array($pageViewsMetrics));

  // Metrics for Bounce Rate
  $bounceRateMetrics = new Google_Service_AnalyticsReporting_Metric();
  $bounceRateMetrics->setExpression("ga:bounceRate");
  $bounceRateMetrics->setAlias("Bounce Rate");

  // Request object for Bounce Rate
  $bounceRate = new Google_Service_AnalyticsReporting_ReportRequest();
  $bounceRate->setViewId($VIEW_ID);
  $bounceRate->setDateRanges($dateRange);
  $bounceRate->setMetrics(array($bounceRateMetrics));

  // Metrics for Page Speed
  $pageSpeedMetrics = new Google_Service_AnalyticsReporting_Metric();
  $pageSpeedMetrics->setExpression("ga:avgPageLoadTime");
  $pageSpeedMetrics->setAlias("Page Speed");

  // Request object for Page Speed
  $pageSpeed = new Google_Service_AnalyticsReporting_ReportRequest();
  $pageSpeed->setViewId($VIEW_ID);
  $pageSpeed->setDateRanges($dateRange);
  $pageSpeed->setMetrics(array($pageSpeedMetrics));
  
  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();

  $body->setReportRequests(
    [
      $pageViews,
      $UniquePageViews,
      $bounceRate,
      $pageSpeed
    ]
  );

  return $analytics->reports->batchGet( $body );
}

// Top 10 Performing pages
function topPages($analytics, $startDate, $endDate, $SiteID) 
{
  // Site ID for pulling in correct site data
  $VIEW_ID = $SiteID;

  // Request object for Top pages
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate($startDate);
  $dateRange->setEndDate($endDate);

  // Create the Metrics object.
  $topPagesMetrics = new Google_Service_AnalyticsReporting_Metric();
  $topPagesMetrics->setExpression("ga:pageViews");
  $topPagesMetrics->setAlias("pageviews");

  //Create the Dimensions object.
  $topPagesDimensions = new Google_Service_AnalyticsReporting_Dimension();
  $topPagesDimensions->setName("ga:pageTitle");

  $ordering = new Google_Service_AnalyticsReporting_OrderBy();
  $ordering->setFieldName("ga:pageviews");
  $ordering->setOrderType("VALUE");   
  $ordering->setSortOrder("DESCENDING");

  // Create the ReportRequest object.
  $topPages = new Google_Service_AnalyticsReporting_ReportRequest();
  $topPages->setViewId($VIEW_ID);
  $topPages->setDateRanges($dateRange);
  $topPages->setDimensions(array($topPagesDimensions));
  $topPages->setMetrics(array($topPagesMetrics));
  $topPages->setPageSize(10);
  $topPages->setOrderBys($ordering);
  
  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();

  $body->setReportRequests(
    [
      $topPages
    ]
  );

  return $analytics->reports->batchGet( $body );
}

// Top 10 ranking events
function topEvents($analytics, $startDate, $endDate, $SiteID) 
{
  // Site ID for pulling in correct site data
  $VIEW_ID = $SiteID;

  // Request object for Users
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate($startDate);
  $dateRange->setEndDate($endDate);

  // Create the Metrics object.
  $topEventsMetrics = new Google_Service_AnalyticsReporting_Metric();
  $topEventsMetrics->setExpression("ga:totalEvents");
  $topEventsMetrics->setAlias("events");

  //Create the Dimensions object.
  $topEventsCategory = new Google_Service_AnalyticsReporting_Dimension();
  $topEventsCategory->setName("ga:eventCategory");

  //Create the Dimensions object.
  $topEventsAction = new Google_Service_AnalyticsReporting_Dimension();
  $topEventsAction->setName("ga:eventAction");

  //Create the Dimensions object.
  $topEventsLabel = new Google_Service_AnalyticsReporting_Dimension();
  $topEventsLabel->setName("ga:eventLabel");

  $ordering = new Google_Service_AnalyticsReporting_OrderBy();
  $ordering->setFieldName("ga:totalEvents");
  $ordering->setOrderType("VALUE");   
  $ordering->setSortOrder("DESCENDING");

  // Create the Report Request object.
  $topCategory = new Google_Service_AnalyticsReporting_ReportRequest();
  $topCategory->setViewId($VIEW_ID);
  $topCategory->setDateRanges($dateRange);
  $topCategory->setDimensions(array($topEventsCategory));
  $topCategory->setMetrics(array($topEventsMetrics));
  $topCategory->setPageSize(10);
  $topCategory->setOrderBys($ordering);

  $topAction = new Google_Service_AnalyticsReporting_ReportRequest();
  $topAction->setViewId($VIEW_ID);
  $topAction->setDateRanges($dateRange);
  $topAction->setDimensions(array($topEventsAction));
  $topAction->setMetrics(array($topEventsMetrics));
  $topAction->setPageSize(10);
  $topAction->setOrderBys($ordering);

  $topLabel = new Google_Service_AnalyticsReporting_ReportRequest();
  $topLabel->setViewId($VIEW_ID);
  $topLabel->setDateRanges($dateRange);
  $topLabel->setDimensions(array($topEventsLabel));
  $topLabel->setMetrics(array($topEventsMetrics));
  $topLabel->setPageSize(10);
  $topLabel->setOrderBys($ordering);
  
  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();

  $body->setReportRequests(
    [
      $topCategory,
      $topAction,
      $topLabel
    ]
  );

  return $analytics->reports->batchGet( $body );
}

// Page stats for compared value ( Page views and unique views )
function cPageStats($analytics, $startDate, $endDate, $SiteID) 
{
  // Site ID for pulling in correct site data
  $VIEW_ID = $SiteID;

  // Request object for Users
  $cDateRange = new Google_Service_AnalyticsReporting_DateRange();
  $cDateRange->setStartDate($startDate);
  $cDateRange->setEndDate($endDate);

  // Metrics forUnique Page Views
  $UniquePageViewsMetrics = new Google_Service_AnalyticsReporting_Metric();
  $UniquePageViewsMetrics->setExpression("ga:uniquePageViews");
  $UniquePageViewsMetrics->setAlias("Unique Page Views");

  // Request object for Unique Page Views
  $UniquePageViews = new Google_Service_AnalyticsReporting_ReportRequest();
  $UniquePageViews->setViewId($VIEW_ID);
  $UniquePageViews->setDateRanges($cDateRange);
  $UniquePageViews->setMetrics(array($UniquePageViewsMetrics));

  // Metrics for Page Views
  $pageViewsMetrics = new Google_Service_AnalyticsReporting_Metric();
  $pageViewsMetrics->setExpression("ga:pageViews");
  $pageViewsMetrics->setAlias("Page Views");

  // Request object for Page Views
  $pageViews = new Google_Service_AnalyticsReporting_ReportRequest();
  $pageViews->setViewId($VIEW_ID);
  $pageViews->setDateRanges($cDateRange);
  $pageViews->setMetrics(array($pageViewsMetrics));

  // Metrics for Bounce Rate
  $bounceRateMetrics = new Google_Service_AnalyticsReporting_Metric();
  $bounceRateMetrics->setExpression("ga:bounceRate");
  $bounceRateMetrics->setAlias("Bounce Rate");

  // Request object for Bounce Rate
  $bounceRate = new Google_Service_AnalyticsReporting_ReportRequest();
  $bounceRate->setViewId($VIEW_ID);
  $bounceRate->setDateRanges($cDateRange);
  $bounceRate->setMetrics(array($bounceRateMetrics));

  // Metrics for Page Speed
  $pageSpeedMetrics = new Google_Service_AnalyticsReporting_Metric();
  $pageSpeedMetrics->setExpression("ga:avgPageLoadTime");
  $pageSpeedMetrics->setAlias("Page Speed");

  // Request object for Page Speed
  $pageSpeed = new Google_Service_AnalyticsReporting_ReportRequest();
  $pageSpeed->setViewId($VIEW_ID);
  $pageSpeed->setDateRanges($cDateRange);
  $pageSpeed->setMetrics(array($pageSpeedMetrics));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();

  $body->setReportRequests(
    [
      $pageViews,
      $UniquePageViews,
      $bounceRate,
      $pageSpeed
    ]
  );

  return $analytics->reports->batchGet( $body );
}

// User stats ( Users and unique users )
function userStats($analytics, $startDate, $endDate, $SiteID) 
{
  // Site ID for pulling in correct site data
  $VIEW_ID = $SiteID;

  // Date range for userStats
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate($startDate);
  $dateRange->setEndDate($endDate);

  // Metrics for Users
  $usersCountMetrics = new Google_Service_AnalyticsReporting_Metric();
  $usersCountMetrics->setExpression("ga:users");
  $usersCountMetrics->setAlias("Users");

  // Request object for Users
  $usersCount = new Google_Service_AnalyticsReporting_ReportRequest();
  $usersCount->setViewId($VIEW_ID);
  $usersCount->setDateRanges($dateRange);
  $usersCount->setMetrics(array($usersCountMetrics));

  // Metrics for New Users
  $uniqueUsersCountMetrics = new Google_Service_AnalyticsReporting_Metric();
  $uniqueUsersCountMetrics->setExpression("ga:newUsers");
  $uniqueUsersCountMetrics->setAlias("New Users");

  // Request object for New Users
  $uniqueUsersCount = new Google_Service_AnalyticsReporting_ReportRequest();
  $uniqueUsersCount->setViewId($VIEW_ID);
  $uniqueUsersCount->setDateRanges($dateRange);
  $uniqueUsersCount->setMetrics(array($uniqueUsersCountMetrics));

  // Metrics for Avg time on site per session
  $avgPageTimeMetrics = new Google_Service_AnalyticsReporting_Metric();
  $avgPageTimeMetrics->setExpression("ga:avgSessionDuration");
  $avgPageTimeMetrics->setAlias("Avg Session Duration");
 
  // Request object for Avg time on site per session
  $avgPageTime = new Google_Service_AnalyticsReporting_ReportRequest();
  $avgPageTime->setViewId($VIEW_ID);
  $avgPageTime->setDateRanges($dateRange);
  $avgPageTime->setMetrics(array($avgPageTimeMetrics));

  // Metrics for Pages viewed per session
  $avgPageViewsMetrics = new Google_Service_AnalyticsReporting_Metric();
  $avgPageViewsMetrics->setExpression("ga:pageviewsPerSession");
  $avgPageViewsMetrics->setAlias("Avg Page Views");
 
  // Request object for Pages viewed per session
  $avgPageViews = new Google_Service_AnalyticsReporting_ReportRequest();
  $avgPageViews->setViewId($VIEW_ID);
  $avgPageViews->setDateRanges($dateRange);
  $avgPageViews->setMetrics(array($avgPageViewsMetrics));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();

  $body->setReportRequests(
    [
        $usersCount,
        $uniqueUsersCount,
        $avgPageTime,
        $avgPageViews
    ]
  );

  return $analytics->reports->batchGet( $body );
}

// User stats for compared values ( Users and unique users )
function cUserStats($analytics, $cStartDate, $cEndDate, $SiteID) 
{
  // Site ID for pulling in correct site data
  $VIEW_ID = $SiteID;

  // Date range for userStats
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate($cStartDate);
  $dateRange->setEndDate($cEndDate);

  // Metrics for Users
  $usersCountMetrics = new Google_Service_AnalyticsReporting_Metric();
  $usersCountMetrics->setExpression("ga:users");
  $usersCountMetrics->setAlias("Users");

  // Request object for Users
  $usersCount = new Google_Service_AnalyticsReporting_ReportRequest();
  $usersCount->setViewId($VIEW_ID);
  $usersCount->setDateRanges($dateRange);
  $usersCount->setMetrics(array($usersCountMetrics));

  // Metrics for New Users
  $uniqueUsersCountMetrics = new Google_Service_AnalyticsReporting_Metric();
  $uniqueUsersCountMetrics->setExpression("ga:newUsers");
  $uniqueUsersCountMetrics->setAlias("New Users");

  // Request object for New Users
  $uniqueUsersCount = new Google_Service_AnalyticsReporting_ReportRequest();
  $uniqueUsersCount->setViewId($VIEW_ID);
  $uniqueUsersCount->setDateRanges($dateRange);
  $uniqueUsersCount->setMetrics(array($uniqueUsersCountMetrics));

  // Metrics for Avg time on site per session
  $avgPageTimeMetrics = new Google_Service_AnalyticsReporting_Metric();
  $avgPageTimeMetrics->setExpression("ga:avgSessionDuration");
  $avgPageTimeMetrics->setAlias("Avg Session Duration");
 
  // Request object for Avg time on site per session
  $avgPageTime = new Google_Service_AnalyticsReporting_ReportRequest();
  $avgPageTime->setViewId($VIEW_ID);
  $avgPageTime->setDateRanges($dateRange);
  $avgPageTime->setMetrics(array($avgPageTimeMetrics));

  // Metrics for Pages viewed per session
  $avgPageViewsMetrics = new Google_Service_AnalyticsReporting_Metric();
  $avgPageViewsMetrics->setExpression("ga:pageviewsPerSession");
  $avgPageViewsMetrics->setAlias("Avg Page Views");
 
  // Request object for Pages viewed per session
  $avgPageViews = new Google_Service_AnalyticsReporting_ReportRequest();
  $avgPageViews->setViewId($VIEW_ID);
  $avgPageViews->setDateRanges($dateRange);
  $avgPageViews->setMetrics(array($avgPageViewsMetrics));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();

  $body->setReportRequests(
    [
        $usersCount,
        $uniqueUsersCount,
        $avgPageTime,
        $avgPageViews
    ]
  );

  return $analytics->reports->batchGet( $body );
}

/**
 * Parses and prints the Analytics Reporting API V4 response.
 *
 * @param An Analytics Reporting API V4 response.
 */
function returnResults($reports) {
  $results = [];
    // Process each report returned
    for ($reportIndex = 0; $reportIndex < count($reports); $reportIndex++) {
        // Get Meta info
        $report = $reports[ $reportIndex ];
        $header = $report->getColumnHeader();
        $dimensionHeaders = $header->getDimensions();
        $hasDimensions = is_array($dimensionHeaders);
        $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
        $rows = $report->getData()->getRows();

        // Loop through each row in the current report
        for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
            $row = $rows[ $rowIndex ];
            $dimensions = $row->getDimensions();
            $metrics = $row->getMetrics();
            // Some of the reports are just returning metrics, there's no dimension grouping.
            // E.g. page views is just a metric.
            // If the report has a dimension, group them into their own array entry
            // ['enquiries' => [..rowData, ...rowData]]
            if ($hasDimensions) {
                for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
                    for ($j = 0; $j < count($metrics); $j++) {
                        $values = $metrics[$j]->getValues();
                        for ($k = 0; $k < count($values); $k++) {
                            $entry = $metricHeaders[$k];
                            $results[$reportIndex][$dimensionHeaders[$i]][$dimensions[$i]] = $values[$k];
                        }
                    }
                }
            // Otherwise just put the metric into the results array directly
            // ['pageviews' => '20']
            } else {
                for ($j = 0; $j < count($metrics); $j++) {
                    $values = $metrics[$j]->getValues();
                    for ($k = 0; $k < count($values); $k++) {
                        $entry = $metricHeaders[$k];
                        $results[$reportIndex][$entry->getName()] = $values[$k];
                    }
                }
            }
        }
    }
    return $results;
}