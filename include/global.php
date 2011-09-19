<?

define('DEBUG_MODE', 1);

/**
 * Define paths
 */

define('ROOT', '/var/www/callermate/');
define('PATH_DATABASE', ROOT . 'database/');
define('PATH_PROPEL_CONF', ROOT . 'build/conf/callermate-conf.php');
define('PATH_PRESENTATION', ROOT . 'presentation/');
define('PATH_APPLICATION', ROOT . 'application/');
define('PATH_CALLS', ROOT . 'application/calls/');
define('PATH_BUILD_CLASSES', ROOT . 'build/classes/callermate/');
define('PATH_BUSINESS', ROOT . 'business/');
define('PATH_TEMPLATES', PATH_PRESENTATION . 'templates/');
define('PATH_PRESENTATION_COMMON', PATH_PRESENTATION . 'common/');

define('WWW_ROOT', 'http://localhost/callermate');
define('WWW_JS', WWW_ROOT . '/js/');
define('WWW_ROOT_ADMIN', WWW_ROOT . '/admin');



/**
 * Service provider URL base
 */

define('FREEJE_URL_BASE', 'http://users.telecomax.net/cabapi/amfphp/json.php/service2.');

/**
 * Debug functions
 */

function printDump($var) {
    print "<pre>";
        var_dump($var);
    print "</pre>";
}