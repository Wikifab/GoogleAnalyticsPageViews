# GoogleAnalyticsPageViews

## Description : 
Cette extension permet d'afficher et surtout d'enregistrer dans les propriétés de la page. le nombre de vues par page.
 
## Installation 
Premièrement, l'extension "GoogleAnalyticsPageViews" ne peut fonctionner correctement sans l'extension "GoogleAnalyticsMetrics".

Télécharger et extraire l'extension. La placer dans le dossier "extension" de votre projet, et le dossier de l'extension elle-même doit aussi se nommer : GoogleAnalyticsPageViews	.

Une fois l'extension chargée, à la fin du fichier LocalSettings.php de votre site, entrez la ligne suivante : 

	wfLoadExtension('GoogleAnalyticsPageViews');

## Utilisation

Vous devez juste ajouter cette ligne sur la page où vous désirez voir le compteur s'afficher. Ça peut être sur un modèle, une page simple, un formulaire.

	{{#getPageViews:}}

