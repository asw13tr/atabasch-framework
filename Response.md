# Response

## » Nesne Oluşturmak
```php
$response = new \Atabasch\System\Response;
```

## » Views klasörndeki php uzantılı dosyaları getirir.
```php
/*
 * app\Views\index.php sayfasını ekrana basar.
 * $title='Anasayfa'; değişkenini oluşturur.
 * */
$response->view('index', ['title'=>'Anasayfa']);

// ve bir httpStatusCode belirtilebilir.
$response->view('index', ['title'=>'Anasayfa'], 200);
```


## » Ekrana JSON çıktısı basar.
```php
$response->json(['key'=>'val', ...]);  
```


## » Dosya indirme işlemi
```php 
// Dosya adı girilmezse dosya adı dosyanın uzantısız kalan kısmı olur.
$response->download('http://hostaddress/file.zip', 'Example');
```

## » Sayfa Yönlendirmek

### 1. Direkt url adresine yönlendirmek
```php
$response->redirect('http://.....'); 
```

### 2. Uygulama içinde bir sayfaya yönlendirmek 
```php 
$response->redirect('/user/edit/1');
```

### 3. Yönlendirmek için bir süre bekletmek
```php 
$response->redirect('/user/edit/1', 5); // 5 saniye sonra yönlendirilir.
```

### 4. Yönlendirirken bit response code göndermek
```php 
$response->redirect('/user/edit/1', 0, 301);
```



## » Http Status Code Belirlemek
```php 
$response->statusCode(200);
$response->view('users');
```

### • Http Status Code numaralarını response classı içinden alabilirsiniz.
```php 
$response->httpStatusCode()->SWITCHING_PROTOCOLS;           // 101
$response->httpStatusCode()->OK;                            // 200
$response->httpStatusCode()->CREATED;                       // 201
$response->httpStatusCode()->ACCEPTED;                      // 202
$response->httpStatusCode()->NONAUTHORITATIVE_INFORMATION;  // 203
$response->httpStatusCode()->NO_CONTENT;                    // 204
$response->httpStatusCode()->RESET_CONTENT;                 // 205
$response->httpStatusCode()->PARTIAL_CONTENT;               // 206
$response->httpStatusCode()->MULTIPLE_CHOICES;              // 300
$response->httpStatusCode()->MOVED_PERMANENTLY;             // 301
$response->httpStatusCode()->MOVED_TEMPORARILY;             // 302
$response->httpStatusCode()->SEE_OTHER;                     // 303
$response->httpStatusCode()->NOT_MODIFIED;                  // 304
$response->httpStatusCode()->USE_PROXY;                     // 305
$response->httpStatusCode()->BAD_REQUEST;                   // 400
$response->httpStatusCode()->UNAUTHORIZED;                  // 401
$response->httpStatusCode()->PAYMENT_REQUIRED;              // 402
$response->httpStatusCode()->FORBIDDEN;                     // 403
$response->httpStatusCode()->NOT_FOUND;                     // 404
$response->httpStatusCode()->METHOD_NOT_ALLOWED;            // 405
$response->httpStatusCode()->NOT_ACCEPTABLE;                // 406
$response->httpStatusCode()->PROXY_AUTHENTICATION_REQUIRED; // 407
$response->httpStatusCode()->REQUEST_TIMEOUT;               // 408
$response->httpStatusCode()->CONFLICT;                      // 408
$response->httpStatusCode()->GONE;                          // 410
$response->httpStatusCode()->LENGTH_REQUIRED;               // 411
$response->httpStatusCode()->PRECONDITION_FAILED;           // 412
$response->httpStatusCode()->REQUEST_ENTITY_TOO_LARGE;      // 413
$response->httpStatusCode()->REQUESTURI_TOO_LARGE;          // 414
$response->httpStatusCode()->UNSUPPORTED_MEDIA_TYPE;        // 415
$response->httpStatusCode()->REQUESTED_RANGE_NOT_SATISFIABLE; // 416
$response->httpStatusCode()->EXPECTATION_FAILED;            // 417
$response->httpStatusCode()->IM_A_TEAPOT;                   // 418
$response->httpStatusCode()->INTERNAL_SERVER_ERROR;         // 500
$response->httpStatusCode()->NOT_IMPLEMENTED;               // 501
$response->httpStatusCode()->BAD_GATEWAY;                   // 502
$response->httpStatusCode()->SERVICE_UNAVAILABLE;           // 503
$response->httpStatusCode()->GATEWAY_TIMEOUT;               // 504
$response->httpStatusCode()->HTTP_VERSION_NOT_SUPPORTED;    // 505
```
