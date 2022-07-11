# Input 

Sayfalara GET ve POST methodları ile gönderilen verileri alır.

## » Nesneyi Kullanmak için çağırmak
```php 
use \Atatabasch\System\Input;
```

## » Getten gelen değerleri almaK

### Tüm değerleri dizi olarak almak
```php 
Input::get();
```

### Sadece bir değeri almak
```php 
// domain.ext/../?page=3&order=asc

Input::get('page'); // 3

Input::get('order'); // asc

// 2. parametre olarak varsayılan bir değer girilir.
Input::get('field', null); // dönen değer: null
```


## » Posttan gelen değerleri almal

### Tüm değerleri dizi olarak almak
```php 
Input::post();
```

### Sadece bir değeri almak
```php 
Input::post('username');
Input::post('password');

// 2. parametre olarak varsayılan bir değer girilir.
Input::post('accept', 'no');
```

### İç içe gelen post verilerini almak
iç içe gelen post verilerini almak için nokta `.` veya `->` ifadeleri kullanılabilir.
```php 
Input::post('user.name');
```
