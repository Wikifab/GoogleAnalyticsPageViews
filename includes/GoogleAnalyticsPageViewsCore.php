<?php
namespace GoogleAnalyticsPageViews;


class GoogleAnalyticsPageViewsCore {

    function initializeAnalytics()
    {
        global $wgGoogleAnalyticsMetricsServiceAccountPath;
        // Creates and returns the Analytics Reporting service object.

        // Use the developers console and download your service account
        // credentials in JSON format. Place them in this directory or
        // change the key file location if necessary.
        $KEY_FILE_LOCATION = $wgGoogleAnalyticsMetricsServiceAccountPath;

        // Create and configure a new client object.
        $client = new \Google_Client();
        $client->setApplicationName($wgGoogleAnanlyticsMetricsAppName);
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $analytics = new \Google_Service_Analytics($client);

        return $analytics;
    }

    function getResults($analytics, $metricID) {
        // Calls the Core Reporting API and queries for the number of pageviews
        $results = $analytics->data_ga->get(
            'ga:'.$metricID,
            '2018-01-01',
            'today',
            'ga:pageviews',
            array( 'dimensions' => 'ga:pagePath'));

        $rows = $results->getRows();
        $arrayWikiPageObject = array();
        $arrayWikiPageViewCount = array();

        foreach ($rows as $row){
            //We only select the page name without "index" and "wiki" and before "?" on the url
            $regexps = ['/^\/index.php\/([^\/?]+)/','/^\/wiki\/([^\/?]+)/'];

            $match=false;
            //We check both regex and if the url doesn't match we continue (as ?action=edit ...)
            foreach ($regexps as $regex) {
                if (preg_match($regex, $row[0], $matchesIndex)) {
                    $match = true;
                    $title = $matchesIndex[1];
                    break;
                }
            }
            if(!$match) {
                continue;
            }

            // Put all the title string as title object
            $titleObject = \Title::newFromURL($title);
            //We check namespace because some pages have "-1" and we don"t want them
            if ($titleObject->getNamespace() != NS_MAIN){
                continue;
            }

            // Put our title object as WikiPage object to get the category
            $wikipage = \WikiPage::factory($titleObject);
            $CategoyNames = $wikipage->getCategories();


            foreach ($CategoyNames as $cat) {
                $catName = $cat->getText();
                //Only if we have the one we want we create an other array with counter of page views and title of page
                if ($catName =='Tutorials'){
                    $titlename = $wikipage->getTitle()->getDBkey();
                    if(isset($arrayWikiPageViewCount[$titlename])) {
                        $arrayWikiPageViewCount[$titlename] += $row[1];
                    } else {
                        $arrayWikiPageViewCount[$titlename] = $row[1];
                    }
                    $arrayWikiPageObject[$titlename] = $wikipage;
                    break;

                }
            }




        }
        // We sort the new array by descending order and with the common key we sort also the array with wikiPage object
        $testArraySorted = arsort($arrayWikiPageViewCount);
        foreach ($arrayWikiPageViewCount as $key=>$value){
            $ordered = array();
            if(array_key_exists($key,$arrayWikiPageObject )){
                $orderedArrayObject[$key] = $arrayWikiPageObject[$key];
                unset($arrayWikiPageObject[$key]);
            }

        }


        return $orderedArrayObject;

    }

    function printResults($results) {


        $wikiExploreResultFormatter = new \WikifabExploreResultFormatter();
        $wikiExploreResultFormatter->setResults($results);
        return $wikiExploreResultFormatter->render();

    }
}