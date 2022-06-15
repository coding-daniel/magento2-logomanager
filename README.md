## CodingDaniel LogoManager
A simple Magento 2 module to manage brands. 
It offers a way to group them in categories and have them showing in a block or widget.

The brands are displayed in a carousel on the front-end

It also offers a way to export them into a CSV file via a CLI command

### Composer
Add the module with `composer require codingdaniel/magento2-logomanager`
 
### Export
CLI command to export the brands in to a CSV file

`bin/magento codingdaniel:logomanager:exportlogos`

Files are stored in the `var` directory
