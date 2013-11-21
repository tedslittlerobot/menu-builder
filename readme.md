Menu Builder
============

### Usage

Get a new MenuRespository, and make a main nav menu
```php
$repo = new Tlr\Menu\MenuRespository;
$nav = $repo->menu( 'nav' );
```

Add some menu items
```php
$home = $nav->item( 'Home', array( 'link' => 'http://eric.com' ) );
$blog = $nav->item( 'Blog', array( 'link' => 'http://eric.com/blog' ) );
$about = $nav->item( 'About', array( 'link' => 'http://eric.com/about-us' ) );
```

Add a sub-menu
```php
$about->item( 'Contact Us', array( 'link' => 'http://eric.com/contact-us' ) );
```

 - @todo talk about active links

### Laravel

Add `Tlr\Menu\Laravel\MenuServiceProvider` to the `providers` array in Laravel's `app/config/app.php`'s, and add `Tlr\Menu\Laravel\Facade\Menu` to the `aliases` array.

You can then use `Menu` as a shortcut for `MenuRepository`, like so:
```php
$navmenu = Menu::menu( 'nav' );
$navmenu->item('Home')
```

### More Advanced Usage

The `MenuRepository` class is a useful way to manage multiple menus on a site
