# Tüm Config Listesini çağırmak
```php 
use Atabasch\Core\Config;

$configs = Config::all();
```

# Bir config değeri çağırmak
```php 
use Atabasch\Core\Config;

// "Configs" dizini içindeki "app.php" içindeki "url" anahtarının değerini verir.
echo Config::get('app.url');

// "Configs" dizini içindeki "mail.php" içindeki "smtp" objesi içindeki "host" anahtarının değerini verir.
echo Config::get('main.smtp.host');
```