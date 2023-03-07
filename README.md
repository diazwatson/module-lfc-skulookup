# LFC_SkuLookUp Magento 2 module
The LFC_SkuLookUp module allows users to search a product by entering its SKU. If product is found it redirects to the product page.
If product is not found it shows a message notifying the user that the product doesn't exist.

## Installation

### Composer (preferable)
1. Download and install the package
```markdown
composer config repositories.stripe/stripe-php "vcs" "git@github.com:diazwatson/module-lfc-skulookup.git"
composer require lfc/module-skulookup
```
2. run `bin/magento setup:upgrade`

### Manual
1. Download [the zip file](https://github.com/diazwatson/module-lfc-skulookup/archive/refs/heads/main.zip)
2. Unzip into `app/code/LFC/SkuLookUp`
3. run `bin/magento setup:upgrade`
