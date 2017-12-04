Yii2 Support
============
Yii2 Support Ticket System

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist powerkernel/yii2-support "*"
```

or add

```
"powerkernel/yii2-support": "*"
```

to the require section of your `composer.json` file.


```
php yii migrate --interactive=0 --migrationPath=@vendor/powerkernel/yii2-support/migrations/ --migrationTable={{%support_migration}}
```


Usage
-----
