# GoogleAnalyticsPageViews

## Description : 
This extension allow you to display and specially to record in the page properties, the counter of views on each pages you desire.

## Installation 
Firstly, the extension "SortedByPageView" depends of the "GoogleAnalyticsMetrics" extension, without it you can't use "GoogleAnalyticsPageViews".
Download and extract the extension file inside your "extension" repository. The extension's repository must be called :"GoogleAnalyticsPageViews".

Once you load the extension, at the end of your LocalSettings.php file add the following line :

	wfLoadExtension('GoogleAnalyticsPageViews');

## Use

You just need to had this line on the page you want, it can be on a template, a form or just an article. 

	{{#getPageViews:}}

