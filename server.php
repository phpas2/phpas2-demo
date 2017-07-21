<?php
/**
 * Copyright (c) 2017 Brett Patterson
 *
 * @author Brett Patterson <bap14@users.noreply.github.com>
 */

require_once('vendor/autoload.php');

use PHPAS2\Server;
use PHPAS2\Message\Adapter;

if (
    array_key_exists('REQUEST_METHOD', $_SERVER) &&
    in_array($_SERVER['REQUEST_METHOD'], ['PUT', 'PUSH', 'POST'])
) {
    try {
        $server = new Server();
    }
    catch (\Exception $e) {
        echo 'An error has occurred: ' . $e->getMessage();
        throw $e;
    }
} else {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?php Adapter::getSoftwareName(); ?></title>
        <meta name="description" content="<?php Adapter::getSoftwareName(); ?>" />
        <meta name="copyright" content="<?php Adapter::getSoftwareName(); ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
        <h2><?php Adapter::getSoftwareName(); ?></h2>
        <p>You have performed an HTTP GET request.  To submit an AS2 message you must send a POST request.</p>
        <p>Copyright &copy; 2017 - <a href="https://bap14.github.io/as2secure/">bap14\as2secure</a></p>
    </body>
    </html>
    <?php
}
