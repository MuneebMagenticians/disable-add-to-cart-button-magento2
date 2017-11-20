# disable-add-to-cart-button-magento2
How to disable add to cart button in Magento 2 on certain products

Step#1 Go to app folder of your Magento 2 and clone the code with the following command
git clone https://github.com/MuneebMagenticians/disable-add-to-cart-button-magento2.git

#Step2 Then run go your root diectory of your store through SSH Terminal and run these commands:
php bin/magento module:enable Magenticians_Mymodule
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento cache:clean
php bin/magento cache:flush

Step#3 Now open the admin panel of your store and go to your product edit page and select DisableAddToCart from Attribute Set drop down.
and Go to your product edit page and select DisableAddToCart from Attribute Set drop down.
Then add the text of your choice which you want to show on a disabled add-to-cart button

Here's a full guide on it: https://magenticians.com/magento-2-disable-add-to-cart-button/
