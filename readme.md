# Route

Yönlendirmeler direkt olarak app klasörü içindeki routes.php dosyasına yazılır

## Basit Kullanım
```php
$Router->get('/merhaba', function(){
	echo "Merhaba Dünya.";
});
```


## Controller Dosyası çağırarak kullanmak
```php
/*
* app/Controllers/Merhaba.php dosyasında ki Merhaba sınıfının index methodunu çalıştırır.
*/
$Router->get('/merhaba', "Merhaba::index");

// Sınıf ve method isimleri bir dizi olarak gönderilebilir.
$Router->get('/merhaba', ["Merhaba", "index"]);


```


## Url için dinamik değerler göndermek
Gönderilebilen dinamik değerler

|İfadeler| Açıklama |
|---|---|
| `{single}` | Rakam, 0 ila 9 arasında pozitif tek sayı  |
| `{bool}`, `{boolean}` | Sadece 0 veya 1 değeri yazılabilir.  |
| `{id}`, `{int}` | Sadece tam sayı değerleri girilebilir.  |
| `{float}`, `{double}`, `{number}` | Ondalıklı sayılar.  |
| `{slug}`, `{string}`, `{}` | Büyük, küçük harf, sayı, tire (-) ve alt tire (_) ifadelerine izin verilir.   |
| `{alphabet}`, `{abc}` | Büyük, küçük harf, tire (-) ve alt tire (_) ifadelerine izin verilir.   |


```php
$Router->get('/user/edit/{int}', function($id){
	// /user/edit/11 isteği için $id 11 değerini alır.
	echo $id;
});



$Router->get('/post/{string}/{int}', function($title, $post_id){
	/*
		• /post/deneme/1
			- $title = deneme
			- $post_id = 1
	*/
});
```


## Zorunlu olmayan parametreler
Dinamik değer alınacak olan kısımda süslü parantez sonrasına eklenen soru işareti(?) o değer gönderilmese de çalışacağı anlamına gelir. *Çalıştırılacak olan method için parametre girilirken default değer girilmeli.*

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


## Yönlendiricilere isim vermek
```php
	$Route->get('/posts', "Post::index")->name('posts');
	$Route->get('/post/{int}', "Post::get")->name('posts.get');
```




## Bir hata sayfası belirlemek
```php
$Router->set404(function(){
	// Çalışması gereken kodlar
});

// veya

$Router->set404("ErrorControllerName::methodName");

// veya

$Router->set404(["ErrorControllerName", "methodName"]);
```
