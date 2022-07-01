# Yönlendirciler olşturmak

app/routes.php dısyası içinde routelar belirtilir. Bu dosya içerisinde Router sınıfına ait methodları kullanarak hangi koşullanrda hangi işlemlerin çalışacağını belirleyeblirisiniz.

Örneğin "domain.ext" web site adrsinizden sonra "/makale/listesi" yazıldığında hangi sınıfın ahngi methodunun çalışacağını belirtebilirisiniz.

Yönlendirmeler direkt olarak app klasörü içindeki routes.php dosyasına yazılır

### » app\routes.php dosya düzeni
```php 
$Router = new \Atabasch\System\Router();

// ... Route kuralları buraya yazılır.

$Router->run();
```



## » Basit Kullanım 
Direkt olarak bir function çalıştırılabilir.
```php
// site.com/merhaba adresi için erkana "Merhaba Dünya" yazar.
$Router->get('/merhaba', function(){
	echo "Merhaba Dünya.";
});
```


## » Controller Dosyası çağırarak kullanmak
Controller dosyaları **app\Controllers** dizininde bulunurlar. 
- Controller dosyalarının ismi dosya içindeki class isimleri ile aynı olmalı.
- Controller dosyaları \Atabasch\System\Controller sınıfından extends edilmeli
- Router içinde sadece sınıf ismi girilirse otomatik olarak **index** methodu aranacaktır.
```php
/*
 * Bu örnekler aşağıdaki bilgilere göre hazırlanmıştır.
 * Url:     http://domain.ext/posts 
 * Dosya:   app\Controllers\Post.php
 * Class:   Post
 */ 
 
 // Method: index
$Router->get('/posts', "Post");

// Method: list
$Router->get('/posts', "Post::list");

// Method: list
$Router->get('/posts', ["Post", "list"]);

// list
$Router->get('/posts', [\Atabasch\Controllers\Post::class, "list"]);

```


## » Url için dinamik değerler göndermek
Url içerisinde değişken değerler alınması gereken koşullarda dinamik değer alan ifadeler kullanılabilir. <br>
Bu değerlere bir kullanıcının silinmesi gerektiğinde gerekli olan kullanıcı id numarası veya bir makale gösterme sayfası için makale başlığı örnek verilebilir.

- Dinamik değerleri süslü parantezler `{...}` içerisine 
- iki nokta üst üste  `:` ile ayrılarak 
- önce anahtar ismi sonra değer tipi yazılarak belirlenir. `{anahtar:tip}`

**Örnek:** `{id:int}, {isim:string}, {durum:boolean}, {rakam:single}, {fiyat:float}, ...`

Aşağıdaki tablo'da özel olarak yazılımcının belirleyeceği anahtar ismlerine  **key** olarak yer verilmiştir.

**NOT:** Bir tip belirtilmeden yazılan anahtar değerler için **slug** tipi geçerlidir.

| İfadeler                                      | Açıklama |
|-----------------------------------------------|---|
| `{key:single}`                                | Rakam, 0 ila 9 arasında pozitif tek sayı  |
| `{key:bool}`, `{key:boolean}`                 | Sadece 0 veya 1 değeri yazılabilir.  |
| `{key:id}`, `{key:int}`                       | Sadece tam sayı değerleri girilebilir.  |
| `{key:float}`, `{key:double}`, `{key:number}` | Ondalıklı sayılar.  |
| `{key:slug}`, `{key:string}`, `{key}`         | Büyük, küçük harf, sayı, tire (-) ve alt tire (_) ifadelerine izin verilir.   |
| `{key:alphabet}`, `{key:abc}`                 | Büyük, küçük harf, tire (-) ve alt tire (_) ifadelerine izin verilir.   |


```php
$Router->get('/user/edit/{id:int}', function($id){
	// /user/edit/11 isteği için $id 11 değerini alır.
	echo $id;
});



$Router->get('/post/{title:slug}/{post_id:id}', function($title){
	/*
		• /post/deneme/1
			- $title = deneme
			- $post_id = 1
	*/
});
```


## » Zorunlu olmayan parametreler
Dinamik değer alınacak olan kısımda süslü parantez sonrasına eklenen soru işareti(?) o değer gönderilmese de çalışacağı anlamına gelir. 

*Çalıştırılacak olan method için parametre girilirken default değer girilmeli.*

```php
$Router->get('/posts/page/{int}?', function($page_number=1){
	/*
		• /posts/page/7
			- $page_number = 7

		• /posts/page
			- $page_number = 1
	*/
});
```


## » Yönlendiricilere isim vermek
Yönlendiricilere isim vermek uygulama içerisinde link verirken veya bir redirect işleminde isim ile yönlendiriciyi çağırmak için gerekebilir. 

- router oluşturan methodların 3. parametresinde bir dizi içinde 'name' indexi ile gönderilebilir
- Router nesnesinin **name** methodu kullanılabilir (Route belirtmeden önce yapılmalı.)
```php
	$Router->get('/posts', "Post::index", ['name' => 'posts']);
	// veya
	$Router->name('post.get')->get('/post/{int}', "Post::get")
```

## » İstek metodları için ayrı routelar ayarlamak
REQUEST_METHOD(GET, POST, PUT, ...) çeşitlerinde çalışacak olan routerlar için aşağıdaki gibi kullanımlar geçerlidir.
```php 
$Router->get($path, $handler, $options=[]);              // REQUEST_METHOD=='GET'
$Router->post($path, $handler, $options=[]);             // REQUEST_METHOD=='POST'
$Router->put($path, $handler, $options=[]);              // REQUEST_METHOD=='PUT'
$Router->patch($path, $handler, $options=[]);            // REQUEST_METHOD=='PATCH'
$Router->delete($path, $handler, $options=[]);           // REQUEST_METHOD=='DELETE'
$Router->head($path, $handler, $options=[]);             // REQUEST_METHOD=='HEAD'
$Router->options($path, $handler, $options=[]);          // REQUEST_METHOD=='OPTIONS'
$Router->any($path, $handler, $options=[]);              // Tümü için geçerli
$Router->match(['get','post'], $handler, $options=[]);     // REQUEST_METHOD=='GET' veya 'POST'
$Router->match(['put','patch'], $handler, $options=[]);    // REQUEST_METHOD=='PUT' veya "PATCH
```


# » Group Kullanımı
Group ile yönlendiricilere toplu halde seçenekler gönderilebilir
```php 

$Router->prefix('/admin')
        ->name('admin.')
        ->middleware(['Authentication'])
        ->group(function($router){
            
            /*  URL: /admin
                Controller: app\Controllers\Admin\Main.php
                Class: Main
                Method: index
                Router Name: admin.home
                Middelware: app\Middlewares\Authentication.php | Authentication::class | run()
            */
            $router->get('/', 'Admin\Main::index', ['name' => 'home']);
            
            
            $router->prefix('/user')->name('user.')->group(function($router){
                /*  URL: /admin/user/list
                    Controller: app\Controllers\Admin\User.php
                    Class: User
                    Method: index
                    Router Name: admin.user.list
                    Middelware: app\Middlewares\Authentication.php | Authentication::class | run()
                */
                $router->get('/list', 'Admin\User::index', ['name' => 'list']);
                
                /*  URL: /admin/user/edit
                    Controller: app\Controllers\Admin\User.php
                    Class: User
                    Method: edit
                    Router Name: admin.user.edit
                    Middelware: app\Middlewares\Authentication.php | Authentication::class | run()
                */
                $router->get('/edit/{id:int}', 'Admin\User::edit', ['name' => 'edit']);
            });
        
        });

```

# » Hata sayfalarında çalıştırılacak router belirlemek
```php
$Router->set404(function(){
	// Çalışması gereken kodlar
});

// veya

$Router->set404("ErrorController::methodName");

// veya

$Router->set404(["ErrorController", "methodName"]);

// veya

$Router->set404([\Atabasch\Controllers\ErrorController::class, "methodName"]);
```
