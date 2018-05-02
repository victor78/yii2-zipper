# Yii2-Zipper
Archiving extension for Yii2 Framework - zip, tar, tar.gz, tar.bz2, 7zip (for zip archive with supporting passwords).
It's shell over [ZippyExt](https://github.com/victor78/ZippyExt).

Расширение для архивации в Yii2 Framework - в виде zip, tar, tar.gz, tar.bz2, 7zip (только для zip архива - в том числе с поддержкой паролей).

__English__:
* [Installation](#installation)
* [Configuration](#configuration)
* [How to use](#how-to-use)

__Русский__:
* [Установка](https://github.com/victor78/yii2-zipper#%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0)
* [Настройка](https://github.com/victor78/yii2-zipper#%D0%9D%D0%B0%D1%81%D1%82%D1%80%D0%BE%D0%B9%D0%BA%D0%B0)
* [Как использовать](https://github.com/victor78/yii2-zipper#%D0%9A%D0%B0%D0%BA-%D0%B8%D1%81%D0%BF%D0%BE%D0%BB%D1%8C%D0%B7%D0%BE%D0%B2%D0%B0%D1%82%D1%8C)

## Installation
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist victor78/yii2-zipper:"~0.0.4"
```

or add

```json
"victor78/yii2-zipper": "~0.0.4"
```

to the require section of your composer.json.

## Configuration
'type' and 'password' are optional.
```php
return [
    //....
    'components' => [
        'zipper' => [
            'class' => 'Victor78\Zipper\Zipper', //required
            'type' => '7zip', //or 'zip' (default), 'tar', 'tar.gz', 'tar.bz2'
            'password' => 'password12345', //optional, only for 7zip type
        ],
    ]
];
```
## How to use
To create archive:
```php
//files to archive
$files = [
  '/path/to/file1',
  '/path/to/file2',
];
//to create tar archive
$tarArchive = Yii::$app->zipper->create('/tmp/archive.tar', $files, true, 'tar');

//to create zip archive by 7zip with password 
$sevenZipArchive = Yii::$app->zipper->create('/tmp/archive.zip', $files, true, '7zip', 'password12345');
//or, if you've configured zipper component like in the example above:
$sevenZipArchive = Yii::$app->zipper->create('/tmp/archive.zip', $files);


$zipArchive = Yii::$app->zipper->create('/tmp/archive.zip', $files, true, 'zip'); 

```

To open archive and extract:
```php
$zipArchive = Yii::$app->zipper->open('/tmp/archive.zip', 'zip');
$tarArchive = Yii::$app->zipper->open('/tmp/archive.tar', 'tar');
$sevenZipArchive = Yii::$app->zipper->open('/tmp/archive.zip', '7zip');
//open 7zip with password
$sevenZipArchiveEncrypted = Yii::$app->zipper->open('/tmp/archive.zip', '7zip', 'password12345');

$zipArchive->extract('/tmp/extracted/');
```

When you configure zipper component with optional properties 'type' and 'password', they will be used as default fourth and fifth parameters in create method, and as default second and third parameters in open method. If you use parameters in this methods obviously, they will overwrite properties from the config.
You can leave out properties in the config and the parameters in the methods at all - in this case Zipper will trying understand which adapter to use, but it doesn't work with 7zip archive.

Both this methods return Archive object. You can find the details about how to use this object and other information in documentation of [ZippyExt](https://github.com/victor78/ZippyExt) libruary.

## Установка
Предпочтительным способом установки является при помощи [composer](http://getcomposer.org/download/).

Либо командой из консоли

```
php composer.phar require --prefer-dist victor78/yii2-zipper:"~0.0.4"
```

либо включением в composer.json в секцию require.

```json
"victor78/yii2-zipper": "~0.0.4"
```

## Настройка
'type' и 'password' - опциональны.
```php
return [
    //....
    'components' => [
        'zipper' => [
            'class' => 'Victor78\Zipper\Zipper', //required
            'type' => '7zip', //или: 'zip' (по умолчанию), 'tar', 'tar.gz', 'tar.bz2'
            'password' => 'password12345', //опционально, работает только при типе 7zip
        ],
    ]
];
```
## Как использовать
Для создания архива:
```php
//files to archive
$files = [
  '/path/to/file1',
  '/path/to/file2',
];
//создать tar архив
$tarArchive = Yii::$app->zipper->create('/tmp/archive.tar', $files, true, 'tar');

//создать zip архив с паролем при помощи 7zip  
$sevenZipArchive = Yii::$app->zipper->create('/tmp/archive.zip', $files, true, '7zip', 'password12345');
//или, если вы настроили компонент Zipper как в примере выше:
$sevenZipArchive = Yii::$app->zipper->create('/tmp/archive.zip', $files);


$zipArchive = Yii::$app->zipper->create('/tmp/archive.zip', $files, true, 'zip'); 

```

Открыть и распаковать архив:
```php
$zipArchive = Yii::$app->zipper->open('/tmp/archive.zip', 'zip');
$tarArchive = Yii::$app->zipper->open('/tmp/archive.tar', 'tar');
$sevenZipArchive = Yii::$app->zipper->open('/tmp/archive.zip', '7zip');
//открыть запароленный zip созданный при помощи 7zip 
$sevenZipArchiveEncrypted = Yii::$app->zipper->open('/tmp/archive.zip', '7zip', 'password12345');

$zipArchive->extract('/tmp/extracted/');
```
Если вы настроили компонент Zipper с опциональными свойствами 'type' и 'password', они будут использованы как дефолтные четвертый и пятый параметры с методе create и второй и третий параметры в методе open.
Если эти параметры в этих методах указываются явно, то они переписывают свойствах из конфига. 
Вы можете опустить свойства из конфига и параметры в методах вообще - в таком случае Zipper попытается понять какой именно адаптер самостоятельно, но это точно не будет работать в случае zip архива, созданного при помощи 7zip.

Оба метода возвращают объект Archive. Вы можете найти детали о том, как использовать данный объект и другую информацию в документации к библотеке [ZippyExt](https://github.com/victor78/ZippyExt).
