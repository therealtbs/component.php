# Component.php
Create static html files from Component.io components.  
Currently WIP

## How-to
1. Create a new project and associated components on https://component.io
2. Create a `tpl` folder in the working directory
  1. Add in your templates with the extension `.html.php`, each template will be processed and the output written to the `dest` folder with the `.php` extension removed
3. Create a `dest` folder in the working directory
4. Run `php component.php` or HTTP `POST` to it if running on a web server

## Reference
### ComponentCls($project, $component)
`$project` the project id, `$component` is the component id.

NOTE: At the moment you can only use components from one project.

The resulting object will have the properties of the component
#### Example
```php
<?php
$thing = \Component\ComponentCls('cio-library', 'errba');
echo $thing->content;
```

### ComponentCls->build_image($img, $tf)
Works the same as the official one, see https://guide.component.io/v1/api/index.html#Component-buildImage-image-options
