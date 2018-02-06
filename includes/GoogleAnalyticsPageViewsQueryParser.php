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

   }


    public static function wfPageViewCountGetPageViews(\Parser $parser) {
        $pageId = $parser->getTitle()->getArticleID();
        if ( isset( $page) ) {
            $title = \Title::newFromText( $page);
            if ( !$title || $title->getArticleID() === 0 ) {
                return '<span class="error">Invalid page ' . htmlspecialchars( $page ) . ' specified.</span>';
            }

            $dbr = wfGetDB( DB_SLAVE );
            $propValue = base64_encode($dbr->selectField( 'page_props',
                'pp_value',
                array( 'pp_page' => $title->getArticleID(), 'pp_propname' => "PageViewsCount" ), // where conditions
                __METHOD__
                ));
            if ( $propValue === false ) {

                return '<span class="error">No prop set for page ' . htmlspecialchars( $page ) . ' specified.</span>';
            }

            $prop = unserialize(base64_decode($propValue));
            if ( !$parser->isValidHalfParsedText( $prop ) ) {
                return '<span class="error">Error retrieving property</span>';
            } else {
                return $parser->unserializeHalfParsedText( $prop );
            }
        } else {

            $prop =  $parser->getOutput()->getProperty( 'PageViewsCount') ;

            return $prop;

        }
    }


}