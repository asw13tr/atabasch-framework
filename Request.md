# Request

## Nesneyi kullanmak için sayfaya dahil etmek

```php
use \Atabasch\Core\Request;
```

## http veya https texti döndürmek
```php
Request::scheme(); // http veya https
```

## Servisin çalıştığı port adresini almak
```php
Request::port(); // 80, 443, ... 
```


## Host adresi bilgisi almak almak
```php
Request::host();   // localhost, 127.0.0.1, domain.ext, ...
// veya
Request::domain(); // localhost, 127.0.0.1, domain.ext, ...
```

## http(s) ile birlikte host adresini almak
```php
Request::hostWithScheme(); // http(s)://localhost, http(s)://127.0.0.1, http(s)://domain.ext, ...
```

## QueryString (?x=y) hariç url bilgisi almak
```php
Request::url();    // http(s)://host.address/current/path
```

## Tam url adresi bilgisi almak
```php
Request::fullUrl();    // http(s)://host.address/current/path?x=y&z=q
```

## Host ve QueryString harici request_uri bilgisi almak
```php
Request::path();   // /current/path
```

## QueryString bilgisini almak
url adresindeki soru işareti (?) kısmından sonraki bölümü verir.

```php
Request::queryString();
```

## QueryString eklenmiş path bilgisi
```php
Request::pathWithQueryString();
```


## Çalışan sayfanın istek metodunu almak
```php
Request::method();
```


## REQUEST_METHOD sorgusu
```php
Request::isMethod('get');
// veya
Request::isMethod('post,put');
// veya
Request::isMethod(['post', 'put', 'patch']);
```

## PATH sorgusu
```php
Request::is('/user/list'); // scheme://host/user/list için true döner
```

## Kullanıcı ip adresini verir.
```php
Request::ip();
```

##
```php
Request::input();
```

##
```php
Request::query();
```

##
```php
Request::params();
```

