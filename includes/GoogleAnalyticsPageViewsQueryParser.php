<?php
/**
 * Class for include googleAnalyticsPageViews area
 *
 * @ingroup Extensions
 *
 * @author Solène Moins
 */
namespace GoogleAnalyticsPageViews;

class GoogleAnalyticsPageViewsQueryParser {

    // Register any render callbacks with the parser
    public static function onParserSetup( &$parser ) {

        // Create a function hook associating the "example" magic word with renderExample()
        $parser->setFunctionHook( 'googleAnalyticsPageViews', 'GoogleAnalyticsPageViews\\GoogleAnalyticsPageViewsQueryParser::renderGoogleAnalyticsPageViewsQueryParser' );

        $parser->setFunctionHook( 'recordPageViews', 'GoogleAnalyticsPageViews\\GoogleAnalyticsPageViewsQueryParser::wfPageViewCountRecordPageViews' );
        $parser->setFunctionHook( 'getPageViews', 'GoogleAnalyticsPageViews\\GoogleAnalyticsPageViewsQueryParser::wfPageViewCountGetPageViews' );

    }

    //
    public static function renderGoogleAnalyticsPageViewsQueryParser( $parser, $results) {

        global $wgGoogleAnalyticsMetricsViewID;

        //Call functions of Core
        $analytics = $this->initializeAnalytics();
        $results =$this->getResults($analytics, $wgGoogleAnalyticsMetricsViewID);
        $output->addHTML($this->printResults($results));

    }


    public static function onBeforePageDisplay( \OutputPage &$out, \Skin &$skin ) {
        $out->addModules('ext.googleanalyticspageviews.js');
        $out->addModuleStyles('ext.googleanalyticspageviews.css');
    }


   public static function wfPageViewCountRecordPageViews(\Parser $parser) {

       $pageViewsCounter =  \GoogleAnalyticsMetricsHooks::getMetric('pageviews', '2005-01-01', 'today');
       $parser->getOutput()->setProperty( 'PageViewsCount', $pageViewsCounter );
       var_dump($pageViewsCounter);

   }


    public static function wfPageViewCountGetPageViews(\Parser $parser) {
        $pageTitle = $parser->getTitle();
        if ( isset( $pageTitle) ) {
            $pageID = $pageTitle->getArticleID();
            $dbr = wfGetDB( DB_SLAVE );
            $res = $dbr->select( 'page_props',
                array(
                    'pp_value'
                ),
                array(
                    'pp_page' => $pageID,
                    // Keep backward compatibility with
                    // the page property name for
                    // Semantic Forms.
                    'pp_propname' => array( 'PageViewsCount' )
                )
            );

            if ( $row = $dbr->fetchRow( $res ) ) {
                return $row['pp_value'];
            }
        } else {

            $prop =  $parser->getOutput()->getProperty( 'PageViewsCount') ;

            return $prop;

        }
    }


}