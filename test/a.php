<?php
header('Content-Type: text/plain');

require_once __DIR__ .'/../Headers/HeadersException.php';
require_once __DIR__ .'/../Headers/Headers.php';

// $h = new Headers();
// $h->setCacheControl('public, max-age=10');
// $h->setConnection('close');
// $h->setXPoweredBy('');
// $h->setXFoo('X Foo!');

// $h->remove('Content-Type'); // doesn't work cos no set in
// $h->removeAll();

// pre($h->getConnection());
// pre($h->get('connection'));
// pre($h);

// $h->send();


// $h = new Headers(array(
//     'XFoo' => 'X Foo!',
//     'XPoweredBy' => 'A',
// ));
// $h->send();

function pre($s, $e = false) {
    printf("%s\n", print_r($s, 1));
    $e && exit;
}