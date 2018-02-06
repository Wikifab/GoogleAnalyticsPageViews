# GoogleAnalyticsPageViews

## Description : 
Cette extension permet d'afficher et surtout d'enregistrer dans les propriétés de la page. le nombre de vues par page.
 
## Installation 
Premièrement, l'extension "GoogleAnalyticsPageViews" ne peut fonctionner correctement sans l'extension "GoogleAnalyticsMetrics".

Télécharger et extraire l'extension. La placer dans le dossier "extension" de votre projet, et le dossier de l'extension elle-même doit aussi se nommer : GoogleAnalyticsPageViews

Comme cette extension dépend de "GoogleAnalyticsMetrics" vous devez aussi ajouter vos propres paramètres dans le localSettings.php :

	$wgGoogleAnalyticsMetricsAllowed ='*'; // the "*" allow all metrics 
	$wgGoogleAnalyticsMetricsServiceAccountPath ='Your/Path/To/YourJsonFileName.json';
	$wgGoogleAnalyticsMetricsEmail='your client_email in your json file';
	$wgGoogleAnalyticsMetricsViewID = 'This is your account's id you can find directly on Google Analytics in your settings.';
	$wgGoogleAnalyticsMetricsDevelopersKey = 'your private Key in your json file';
	$wgGoogleAnanlyticsMetricsAppName = 'The name of you application';
	
	
	// Load the Google API PHP Client Library.
	require_once __DIR__ . '/vendor/autoload.php';
		.

Une fois l'extension chargée, à la fin du fichier LocalSettings.php de votre site, entrez la ligne suivante : 

	wfLoadExtension('GoogleAnalyticsPageViews');

## Utilisation

Vous devez juste ajouter ces deux lignes sur la page où vous désirez voir le compteur s'afficher. Ça peut être sur un modèle, une page simple, un formulaire.

	{{#recordPageViews:}}
	{{#getPageViews:}}

