FileManagerBundle
=================
[File manager](https://github.com/konstantin-nizhinskiy/FileManager) symfony bundle

* [setup](#setup)
* [Config bundle](#config-bundle)
* [Todo](#todo)
    
## Setup

#### composer
```sh
    $ composer require nks/file-manage-bundle
```

#### app/AppKernel.php
```php
    <?php
    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new FileManagerBundle\FileManagerBundle(),
            // ...
        );
    }
```

#### app/config/routing.yml
```yml
FileManagerBundle:
    resource: "@FileManagerBundle/Resources/config/routing.yml"
    prefix:   /fm
```

## Config bundle

```yml
file_manager:
  web_dir: "%kernel.root_dir%/../web/" // web directory
  file_manager_dir: "fileManager/" // file manager directory in web
  type_file: // type file load
    - 'jpg'
    - 'png'
```

## @todo
 - fix bug delete folder not clear yml file chain