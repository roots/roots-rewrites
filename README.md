# Roots Rewrites

Roots Rewrites will rewrite your static theme and plugin assets:

```
/wp-content/themes/themename/assets/css/ to /assets/css/
/wp-content/themes/themename/assets/js/  to /assets/js/
/wp-content/themes/themename/assets/img/ to /assets/img/
/wp-content/plugins/                     to /plugins/
```

**Note: If you use [Composer to manage WordPress](http://roots.io/using-composer-with-wordpress/) then you don't need to use this plugin, as your paths would look like:**

```
/app/themes/themename/assets/css/
/app/themes/themename/assets/js/
/app/themes/themename/assets/img/
/app/plugins/
```

## Requirements

* [Roots Theme](http://roots.io/) (6.5.1+)

## Installation

It is recommended to install this plugin prior to installing your Roots theme as the `roots_rewrites()` plugin function is only called on the `after_setup_theme` action. If this plugin is installed after the theme, you may have to update your permalink settings to force the .htaccess writes.

If you're using Nginx, you'll need to add the Roots rewrites to your server config before the PHP block (`location ~ \.php$`):

```nginx
location ~ ^/assets/(img|js|css|fonts)/(.*)$ {
  try_files $uri $uri/ /wp-content/themes/roots/assets/$1/$2;
}
location ~ ^/plugins/(.*)$ {
  try_files $uri $uri/ /wp-content/plugins/$1;
}
```

## Support

Use the [Roots Discourse](http://discourse.roots.io/) to ask questions and get support.

## Changelog

### 1.0.0: November 5th, 2013
* Removed from [Roots Theme](http://roots.io/), moved to plugin

## License

MIT License
