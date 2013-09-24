**Usage**

- Setting & sending headers

```php
// so
$h = new Headers();
$h->setCacheControl('public, max-age=10');
$h->send();

// or
$h = new Headers(array(
    'Cache-Control' => 'public, max-age=10',
    // ...
));
$h->send();

// or
$h = new Headers();
$h->set('Cache-Control', 'public, max-age=10');
$h->send();

$h = new Headers();
$h->set(array(
    'Cache-Control' => 'public, max-age=10',
    'Pragma' => 'no-cache',
    // ...
));
$h->send();
```

- Getting headers

```php
// all valid
print $h->getCacheControl();
print $h->get('Cache-Control');
print $h->get('cache-control');
```

- Removing headers

```php
// remove one
$h->remove('Cache-Control');
$h->remove('cache-control');
// remove all
$h->removeAll();
```

Note: Header object can play with self-own headers only
```php
header('Content-Type: text/plain');
// ...

// these won't work for 'Content-Type' if not presented in object
$h->remove('Content-Type');
$h->removeAll();
```
