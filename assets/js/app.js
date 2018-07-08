/**
 * Ici, on importe les javascripts dont on a besoin
 */
const $ = require('jquery');
require('bootstrap');

// On doit simplement déclarer comme globale jQuery puisqu'on s'en sert dans d'autres fichiers
// qui ne sont pas traités dans Webpack
global.$ = global.jQuery = $;
/**
 * Et on peut bien sur écrire du code JS que l'on souhaite !
 */
