## CodingDaniel LogoManager

### Composer
Add to `composer.json` file:

```
"repositories": {
    "codingdaniel": {
        "type": "vcs",
        "url": "https://github.com/coding-daniel/magento-logomanager"
    }
}

```
Then require with `composer require codingdaniel/magento2-logomanager`
 
### Export
CLI commando to export logos in to a CSV file

`bin/magento codingdaniel:logomanager:exportlogos`

Files are stored in the `var` directory
