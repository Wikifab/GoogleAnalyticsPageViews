# GoogleAnalyticsPageViews

## Description : 
This extension allow you to display and specially to record in the page properties, the counter of views on each pages you desire.

## Installation 
Firstly, the extension "SortedByPageView" depends of the "GoogleAnalyticsMetrics" extension, without it you can't use "GoogleAnalyticsPageViews".

As it depends on "GoogleAnanlyticsMetrics" you also need to put your own settings on your localSettings.php file. 

Please follow the instructions at https://developers.google.com/analytics/devguides/config/mgmt/v3/quickstart/service-php

	$wgGoogleAnalyticsMetricsAllowed ='*'; // the "*" allow all metrics 
	$wgGoogleAnalyticsMetricsServiceAccountPath ='Your/Path/To/YourJsonFileName.json';
	$wgGoogleAnalyticsMetricsEmail='your client_email in your json file';
	$wgGoogleAnalyticsMetricsViewID = 'This is your account's id you can find directly on Google Analytics in your settings.';
	$wgGoogleAnalyticsMetricsDevelopersKey = 'your private Key in your json file';
	$wgGoogleAnanlyticsMetricsAppName = 'The name of you application';

You might have trouble getting it to work and get this error "User does not have sufficient permissions for this account". In that case, for $wgGoogleAnalyticsMetricsViewID, use the table id instead of your account's id, which you can find on the management page under view (parameters -> view id)
	
	
	// Load the Google API PHP Client Library.
	require_once __DIR__ . '/vendor/autoload.php';
	
Download and extract the extension file inside your "extension" repository. The extension's repository must be called :"GoogleAnalyticsPageViews".

Once you load the extension, at the end of your LocalSettings.php file add the following line :

	wfLoadExtension('GoogleAnalyticsPageViews');

## Use

You just need to had those lines on the page you want, it can be on a template, a form or just an article. 

	{{#recordPageViews:}}
	{{#getPageViews:}}

