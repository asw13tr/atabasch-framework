# Request

## Nesne Oluşturmak
```php
$request = new \Atabasch\System\Request;
```

## http veya https texti döndürmek
```php
$request->scheme(); // http veya https
```

## Servisin çalıştığı port adresini almak
```php
$request->port(); // 80, 443, ... 
```


## Host adresi bilgisi almak almak
```php
$request->host();   // localhost, 127.0.0.1, domain.ext, ...
// veya
$request->domain(); // localhost, 127.0.0.1, domain.ext, ...
```

## http(s) ile birlikte host adresini almak
```php
$request->hostWithScheme(); // http(s)://localhost, http(s)://127.0.0.1, http(s)://domain.ext, ...
```

## QueryString (?x=y) hariç url bilgisi almak
```php
$request->url();    // http(s)://host.address/current/path
```

## Tam url adresi bilgisi almak
```php
$request->fullUrl();    // http(s)://host.address/current/path?x=y&z=q
```

## Host ve QueryString harici request_uri bilgisi almak
```php
$request->path();   // /current/path
```

## QueryString bilgisini almak
url adresindeki soru işareti (?) kısmından sonraki bölümü verir.

```php
$request->queryString();
```

## QueryString eklenmiş path bilgisi
```php
$request->pathWithQueryString();
```


## Çalışan sayfanın istek metodunu almak
```php
$request->method();
```


## REQUEST_METHOD sorgusu
```php
$request->isMethod('get');
// veya
$request->isMethod('post,put');
// veya
$request->isMethod(['post', 'put', 'patch']);
```

## PATH sorgusu
```php
$request->is('/user/list'); // scheme://host/user/list için true döner
```

## Kullanıcı ip adresini verir.
```php
$request->ip();
```

##
```php
$request->input();
```

##
```php
$request->query();
```

##
```php
$request->params();
```

