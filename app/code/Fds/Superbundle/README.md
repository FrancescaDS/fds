# Fds_Superbundle
Superbundle is 'bundle of bundle': one product (with one SKU) is sold in packages of Y, Y and Z units (Boxes), like boxes of bottles of wine.  

# Legenda
BOX >> bundle product that contains one/more instances of only one simple product, they must have SUPERBUNDLE: Bundled box Attribute switched on.
SUPERBUNDLE >> simple product that is contained in BOXES.

# How it works
The page of the simple product, the Superbundle:
  - Shows prices and other options (as short description) from its Boxes.
  - Can have reviews (Box pages cannot have reviews)
  - Shows the long description of itself
From the Superbundle page the user can choose the Product they want to buy
Linking from the cart on the Box the system comes back to the Superbundle pages
The Box has an its own page, but it is reachable only through direct link, such as for a special offer.

# Installation Guide
- Paste the Superbundle folder into YourProject/app/code/Fds folder
- From Terminal run, in the root of YourProject
    $sudo rm -rf var/cache var/generation var/page_cache
      (this command requires systempassword)

    $php bin/magento setup:upgrade
    $php bin/magento setup:di:compile
    $php bin/magento setup:static-content:deploy -f
    $php bin/magento cache:clean
    $php bin/magento cache:flush

- Check the module status
    $php bin/magento module:status

- You can enable or disable the module with:
    $php bin/magento module:enable Fds_Superbundle
    $php bin/magento module:disable Fds_Superbundle

# Remove module
- From Terminal run, in the root of YourProject
    $php bin/magento module:disable Fds_Superbundle
- In DataBase run:
    DELETE FROM setup_module WHERE setup_module.module = 'Fds_Superbundle';
    DELETE FROM eav_attribute WHERE eav_attribute.attribute_code = "fdssb_box";
    DELETE FROM eav_attribute WHERE eav_attribute.attribute_code = "fdssb_box_selected";
    DELETE FROM eav_attribute WHERE eav_attribute.attribute_code = "fdssb_sorting_box";

# Make it works
- Admin -> Stores -> Configuration ->Fds -> Superbundle 
    Module Enable: Yes
    
- Make new sub category:
      Enable Category: No
      Include in Menu: No
      Category Name: 'Boxes'

- Create a regular simple product, the 'Superbundle' (eg 'Chianti')

- Create the bundle product, the 'Box', with an X number of the simple product (ONLY that product)
Example of Box:
Product name: 'Chianti 3 bottles'
SKU: Chianti_3
Price: regular price (price simple product * X)
Dynamic Price: No
Advanced Pricing: (if there is special price for bundle)
      Special Price: % 66.66 (this will be the 'As low as' price in the product page)
      Special View: As Low As
Stock status: In Stock
Category: Boxes
Visibility: Search
SUPERBUNDLE: Bundled box: Yes
SUPERBUNDLE: Preselected box: Yes (the preselected box in the Superbundle page)
SUPERBUNDLE: Sorting box: 2 (Order of the Box in the Superbundle page)
Content:
    - Description: visible in the Box page, when it is direct linked, like during a promotion
    - Short desc: visible in the Superbundle page
Bundle Items:
  Ship Bundle Items: Together
  Option Title: 'Box 3 bottles'
  Input Type: Drop-down
  Required: checked
  Add the simple Product
    Is Default: checked
    Price: 0.0000
    Price Type: Fixed
    Default Quantity: 3
    User Defined: Unchecked
Images and Video: Insert the image
Search Engine Optimization:
    URL Key: chianti-3-bottles
    ...
    ...
Product in Websites:
    Check Website
