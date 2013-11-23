Menu Builder
============

- [Installation](#installation)
- [Basic Usage](#basic-usage)
- [Managing Multiple Menus](#managing-multiple-menus)
- [Laravel Integration](#laravel)

### Installation

Until it's on packagist, you can install it using composer's [standard VCS feature](http://getcomposer.org/doc/05-repositories.md#vcs)

```javascript
{
	"repositories": [
		{
			"type": "vcs",
			"url": "https://github.com/tedslittlerobot/menu-builder"
		}
	],
	"require": [
		"tlr/menu": "dev-master"
	]
}
```

### Basic Usage

Get a new MenuRespository, and make a main nav menu
```php
$menu = new Tlr\Menu\MenuItem;
```

Add some menu items
```php
$home = $menu->item( 'Home', array( 'link' => 'http://eric.com' ) );
$blog = $menu->item( 'Blog', array( 'link' => 'http://eric.com/blog' ) );
$about = $menu->item( 'About', array( 'link' => 'http://eric.com/about-us' ) );
```

Add a sub-menu
```php
$about->item( 'Contact Us', array( 'link' => 'http://eric.com/contact-us' ) );
```

### Managing Multiple Menus

If you have, say, a header and a footer menu, you can use the MenuRepository class:

```php
$repo = new MenuRepository;

$headerMenu = $repo->menu( 'header-nav' );
$footerMenu = $repo->menu( 'footer-nav' );
```

and you can retrieve the menu later in your code in the same way:

```php
$headerMenu = $repo->menu( 'header-nav' ); // the existing menu instance
$newMenu = $repo->menu( 'other-nav' ); // a new instance, because the 'other-nav' key hasn't been used yet
```

### Laravel

Add `Tlr\Menu\Laravel\MenuServiceProvider` to the `providers` array in Laravel's `app/config/app.php`'s, and add `Tlr\Menu\Laravel\Facade\Menu` to the `aliases` array.

You can then use the `Menu` facade as a shortcut for the `MenuRepository` class, like so:
```php
$menu = Menu::menu( 'nav' );
$menu->item('Home')
```

after which, you can access it again later with `Menu::menu( 'nav' )`.

The laravel version of the class can be echoed out (which calls the `render()` method). This renders the menu using Laravel's blade view system. If you want to use a custom view, you can pass the view's name to the `$menu->setView( 'my.menu.view' )` method, which will have a `$menu` variable available.

NOTE: if you use the default view, then you must add the [HtmlBuilder util from this package](https://github.com/tedslittlerobot/laravel-utils)
