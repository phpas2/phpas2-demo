<?php
/**
 * Copyright (c) 2017 Brett Patterson
 *
 * @author Brett Patterson <bap14@users.noreply.github.com>
 */

namespace PHPAS2Demo;

require_once('vendor/autoload.php');

use PHPAS2\Client;
use PHPAS2\Message;
use PHPAS2\Message\Adapter;
use PHPAS2\Partner;

\ladybug_set_format('html');
\ladybug_set_theme('Modern');

$message = new Message();

// Remote
$receivingPartner = new Partner();
// Local
$sendingPartner = new Partner();

$message->getAdapter()
    ->setReceivingPartner($receivingPartner)
    ->setSendingPartner($sendingPartner);

$receivingPartner->loadFromConfig($_REQUEST['as2to']);
$sendingPartner->loadFromConfig($_REQUEST['as2from']);

$tmpFile = $message->getAdapter()->getTempFilename();
file_put_contents($tmpFile, 'Test Message from ' . Adapter::getServerSignature());

$message->setReceivingPartner($receivingPartner)
    ->setSendingPartner($sendingPartner)
    ->addFile($tmpFile)
    ->encode();

$client = new Client();
$client->sendRequest($message);

echo 'Message sent!';
ld($client->getResponse());
