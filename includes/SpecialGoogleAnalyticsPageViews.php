<?php
namespace GoogleAnalyticsPageViews;
use SpecialPage;
include_once 'GoogleAnalyticsPageViewsCore.php';


class SpecialGoogleAnalyticsPageViews extends SpecialPage {
    function __construct() {
        parent::__construct( 'GoogleAnalyticsPageViews' );
    }

    function execute( $par ) {
        $request = $this->getRequest();
        $output = $this->getOutput();
        $this->setHeaders();
        global $wgGoogleAnalyticsMetricsViewID ;

        # Get request data from, e.g.
        $param = $request->getText( 'param' );
        //Call functions of Core
        $core = new GoogleAnalyticsPageViewsCore;
        $analytics = $core->initializeAnalytics();
        $results =$core ->getResults($analytics, $wgGoogleAnalyticsMetricsViewID);


        $output->addHTML($core->printResults($results));


    }




}