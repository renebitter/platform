[titleEn]: <>(Using custom CSS and Javascript in the Storefront)
[metaDescriptionEn]: <>(Quite often your plugin will have to change a few templates for the Storefront. Those might require custom stylings to look neat and a few lines of javascript, to add special functionality. This How To will explain how this is done.)

Quite often your plugin will have to change a few templates for the Storefront.
Those might require custom stylings to look neat and a few lines of javascript, to add special functionality.
This How To will explain how this is done.

## Setup

You won't learn to create a plugin in this guide, head over to our [Plugin quick start guide](./../2-internals/4-plugins/010-plugin-quick-start.md) to
create your plugin first.
The plugin in this example will be called `StorefrontAssets`.

## Injecting into the storefront

If you want to add static assets like images or fonts, you can place them in the public folder of your Plugin.
They will be copied to the public folder of Shopware 6 when you build the storefront. Your plugin shouldn't
put its assets into another directory outside of its scope though -  but how do those assets from plugins actually work then?

For CSS and Javascript things are a bit different. CSS and SCSS is handled by a PHP SASS compiler.

Javascript can't be compiled by PHP so [webpack](https://webpack.js.org/) is used for compilation.
This also means that you have to ship your plugin with the javascript already build.

If you don't want to create a custom webpack configuration, you can use the Shopware webpack build 
configuration. In order to do that, you have to define an entry-point, so webpack knows where to get started.
In Shopware 6, this entry-point is a `main.js` file inside of the following directory:
`<plugin root>/src/Resources/storefront/`

*Note: For administration files, the path would be same, but ending with `administration` of course.*

Go ahead and create a `main.js` in that directory.

### Adding styles

By default, Shopware looks in the `<plugin root>/src/Resources/storefront/style` folder of your plugin
and collects all *.css and *.scss file in that folder (non recursive).

To try it out, create a main.scss file in the folder mentioned above 

Inside of the `.scss` file, add some styles to see if it's working. In this example, 
the background of the `body` will be changed.

```scss
body {
    background: blue;
}
```

### Loading the assets

Since Shopware knows where your style files are located, they are automatically compiled, compressed 
and loaded in the storefront. For javascript you normally would have two locations where your *.js files
are located. You have your main.js as an entry point and by default the compiled js file is saved at
`<plugin root>/src/Resources/dist/storefront/js/<plugin-name>.js`
You can tell shopware to include this file by changing the storefront script path in your plugin
bootstrap file.

Example:
```php
<?php declare(strict_types=1);

namespace Swag\PluginQuickStart;

use Shopware\Core\Framework\Plugin;

class PluginQuickStart extends Plugin
{
    public function getStorefrontScriptPath(): string
    {
        return 'Resources/dist/storefront/js';
    }
}
```

### Testing its functionality

Now you want to test if your custom styles actually apply to the Storefront.
For this, you have to execute the compiling and building of the `.js` and `.css` files first.
This is done using the following command from inside the development template directory:

```bash
./psh.phar storefront:build
```

**Important note: This might also generate a `public` directory inside your plugin. Always ship this directory with your plugin,
do not exclude or remove it!**

That's it! Open the Storefront and see it turning blue, due to your custom styles!

## Source

There's a GitHub repository available, containing this example source.
Check it out [here](https://github.com/shopware/swag-docs-storefront-assets).