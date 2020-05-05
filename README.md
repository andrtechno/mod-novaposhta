# mod-pages

Module for PIXELION CMS

[![Latest Stable Version](https://poser.pugx.org/panix/mod-novaposhta/v/stable)](https://packagist.org/packages/panix/mod-novaposhta)
[![Total Downloads](https://poser.pugx.org/panix/mod-novaposhta/downloads)](https://packagist.org/packages/panix/mod-novaposhta)
[![Monthly Downloads](https://poser.pugx.org/panix/mod-novaposhta/d/monthly)](https://packagist.org/packages/panix/mod-novaposhta)
[![Daily Downloads](https://poser.pugx.org/panix/mod-novaposhta/d/daily)](https://packagist.org/packages/panix/mod-novaposhta)
[![Latest Unstable Version](https://poser.pugx.org/panix/mod-novaposhta/v/unstable)](https://packagist.org/packages/panix/mod-novaposhta)
[![License](https://poser.pugx.org/panix/mod-novaposhta/license)](https://packagist.org/packages/panix/mod-novaposhta)


## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

#### Either run

```
php composer require --prefer-dist panix/mod-novaposhta "*"
```

or add

```
"panix/mod-novaposhta": "*"
```

to the require section of your `composer.json` file.


#### Add to web config.
```
    'modules' => [
        'novaposhta' => ['class' => 'panix\mod\novaposhta\Module'],
    ],
```
#### Migrate
```
php yii migrate --migrationPath=vendor/panix/mod-novaposhta/migrations
```
