Menu Builder
============

> An attempt to take a bit of the stress and boilerplate out of building menus (or indeed any list, because that's basically what a menu is)
> Comes with support for Laravel 4 (other frameworks to follow)

- [Installation](#installation)
- [Basic Usage](#basic-usage)
- [Managing Multiple Menus](#managing-multiple-menus)
- [Laravel Integration](#laravel)

### Installation

Simply require the library like so:

```bash
composer require tlr/menu "2.0.*"
````

### Basic Usage

Get a new MenuRespository, and make a main nav menu
```php
$menu = new Tlr\Menu\MenuItem;
```

Add some menu items
```php
$home = $menu->item( 'home', 'Home', 'http://foo.com' );
$blog = $menu->item( 'blog', 'Blog', 'http://foo.com/blog' );
$about = $menu->item( 'about', 'About', 'http://foo.com/about-us' );
```

Add a sub-menu
```php
$about->item( 'where-we-are', 'Where We Are', 'http://eric.com/where-are-we' );
$about->item( 'contact-us', 'Contact Us', 'http://eric.com/contact-us' );
```

Then in you view, you can iterate over the menu's items using the $menu->getItems() method.

You can retreive an existing item by using its key:

```php
$blog = $menu->item('blog');
```

The method signature is as follows:

```
$menu->item( $key[, $title, $options, $attributes, $index] )
```

`$key` is a string key used to retrieve the item. It is also added, in slugified form, to the class attribute. It is the only required argument.
`$title` is the text to display in the list item
`$options` is an array of options for the item. If you pass a string to the third item, it will assume it is the link option, and will convert it to `array( 'link' => $string )`
`$attributes` is an array of attributes for the HTML element
`$index` is an optional index to insert a new menu item at. The indices, by default, default to increments of 100, starting at 100, so you can easily insert items in between them.

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

Add `Tlr\Menu\Laravel\MenuServiceProvider` to the `providers` array in Laravel's `app/config/app.php`'s, and add `'Menu' => 'Tlr\Menu\Laravel\MenuFacade'` to the `aliases` array.

You can then use the `Menu` facade as a shortcut for the `MenuRepository` class, like so:
```php
$menu = Menu::menu( 'nav' );
$menu->item('Home')
```

after which, you can access it again later with `Menu::menu( 'nav' )`.

The Laravel version of the class can be echoed out (which will call the `render()` method). This renders the menu using Laravel's blade templating system. You have two options for customising:
- You can override the Menu Builder views (run `php artisan view:publish tlr/view`, then edit those files).
- You can pass a view to the parent menu like so. This view will have the `MenuItem` object available as the `$menu` variable:

```php
$menu->setView( 'my.menu.view' );
```
