# Url

Nesneye ait kod örnekleri aşağıdai örnek adress üzerinden gösterilecektir.

**Örnek Adres: http://example.ext/post/list?order=asc&field=name**

## » Nesne Oluşturmak

```php
$url = new \Atabasch\Core\Url;
```

## » Uygulama url adresini verir.
```php
// http://example.ext
$url->root();

// http://example.ext
$url->app();

// http://example.ext
$url->get();
```

## » Çalılşan sayfanın url adresini verir.
```php
// http://example.ext/post/list?order=asc&field=name
$url->current();
```



## » Yol eklenmiş url adresi almak.
```php
// http://example.ext/post/1/delete
$url->get('/post/1/delete');
```




## » Çalışan sayfanın route yolunu almak (app url hariç)
```php
// /post/list
$url->requestUri();

// /post/list?order=asc&field=name
$url->requestUri(true);
```


## » QueryString'i almak
```php
// order=asc&field=name
$url->queryString();
```


## » QueryString'i verilerini dizi olarak almak
```php
/*
 * ["post", "list"] 
 */
 $url->requestUriParts();
```






