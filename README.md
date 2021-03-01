# WordPress Plugin Boilerplate

This is a boilerplate WordPress plugin.
It contains all basic classes and configurations to manage a website with WordPress. 
It palys perfectly together with the [vuejs WordPress Theme Boilerplate](https://github.com/parallactic-dev/vuejs-wp-theme-boilerplate) and it's content block system.

## Features

- [ACF REST Integration](https://www.advancedcustomfields.com/) (ACF is required as must plugin)
- Basic content blocks built with ACF
- SEO/Meta fields
- An out of the box working contact form


## Getting started

1. **Clone** the repo inside your `wp-content/plugin/` directory
2. **Change** plugin **name, description ...**
3. **Install** composer dependencies `composer install`
4. **Install ACF plugin** in your WordPress instance.
5. You may want to disable the Gutenberg Editor to have a better experience with ACF and content blocks.
   You could use this [plugin](https://wordpress.org/plugins/disable-gutenberg/) to achieve a proper disabling.
6. **Activate the plugin** in your WordPress instance.
