# Roots Rewrites

Roots Rewrites enables clean URL rewrites for your WordPress plugins and theme assets folder.

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

* Apache with mod_rewrite enabled through .htaccess; Nginx (see Installation for configuration); or any other server that allows you to control its rewrite rules.

* [Roots Theme](http://roots.io/) (6.5.1+) is recommended for compatibility, but is not a requirement since 1.0.1

## Installation

Apache will flush rewrite rules on activation and deactivation.

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

Before asking for help, please visit your site's permalinks page to flush rewrite rules; and open .htaccess to check that the rules are being written correctly.

If you still have issues, please visit [Roots Discourse](http://discourse.roots.io/) and search for answers or ask questions.

## Changelog

### 1.0.1: August 14th, 2014
* Supports non-Roots based themes, de/activation hooks added to flush rewrites

### 1.0.0: November 5th, 2013
* Removed from [Roots Theme](http://roots.io/), moved to plugin

## License

MIT License
