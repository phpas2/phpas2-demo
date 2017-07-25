<?php
/**
 * Copyright (c) 2017 Brett Patterson
 *
 * @author Brett Patterson <bap14@users.noreply.github.com>
 */

namespace PHPAS2Demo;

require_once('vendor/autoload.php');

use PHPAS2\Client;
use PHPAS2\Exception\MDNFailure;
use PHPAS2\Message;
use PHPAS2\Message\Adapter;
use PHPAS2\Partner;

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
    ->addFile($tmpFile, 'text/plain', 'test-as2-file.txt')
    ->encode();

try {
    $client = new Client();
    $client->sendRequest($message);

    echo 'Message sent and received successfully.';
}
catch (MDNFailure $e) {
    echo 'Message failed to be sent: "' . $e->getMessage() . '"';
}
