# Input 

Sayfalara GET ve POST methodları ile gönderilen verileri alır.

## » Nesne Oluşturmak
```php 
$input = new \Atatabasch\System\Input();
```

## » Getten gelen değerleri almaK

### Tüm değerleri dizi olarak almak
```php 
$input->get();
```

### Sadece bir değeri almak
```php 
// domain.ext/../?page=3&order=asc

$input->get('page'); // 3

$input->get('order'); // asc

// 2. parametre olarak varsayılan bir değer girilir.
$input->get('field', 'id'); // id
```


## » Posttan gelen değerleri almal

### Tüm değerleri dizi olarak almak
```php 
$input->post();
```

### Sadece bir değeri almak
```php 
$input->post('username');
$input->post('password');

// 2. parametre olarak varsayılan bir değer girilir.
$input->post('accept', 'no');
```

### İç içe gelen post verilerini almak
iç içe gelen post verilerini almak için nokta `.` `-` veya `->` ifadeleri kullanılabilir.
```php 
$input->post('user.name');
```
