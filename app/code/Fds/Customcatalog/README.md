# Fds_Customcatalog
MODULE for catalog customization
1) Simple product Description and Short Description are taken from the first enabled configurable parent product if the attribute fdscc_description/fdscc_shortdescription is YES
2) AddProduct/s with external link

# How it works
1) Override part of the magento_catalog view.phtml In the simple product page the Short_Description and Description content are taken from the Configurable parent if the related attribute in admin is YES
2) In Controller 
   Example of URL: 
   http://sandboxm2.local/uk/addproduct?idproduct=1,26&utm_campaign=xxx&utm_source=zzz
   Example of URL with COUPONCODE (do NOT use the code in Dotmailer>>it does not work with utm params)
   http://sandboxm2.local/uk/addproduct?idproduct=1,26&code=freetotest
   If the URL contains "code" AND other parameters the code will not be consider   

# Installation Guide
- Paste the Customcatalog folder into YourProject/app/code/Fds folder
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
    $php bin/magento module:enable Fds_Customcatalog
    $php bin/magento module:disable Fds_Customcatalog

# Remove module
- From Terminal run, in the root of YourProject
    $php bin/magento module:disable Fds_Customcatalog
- In DataBase run:
1)
    DELETE FROM setup_module WHERE setup_module.module = 'Fds_Customcatalog';
    DELETE FROM eav_attribute WHERE eav_attribute.attribute_code = "fdscc_description";
    DELETE FROM eav_attribute WHERE eav_attribute.attribute_code = "fdscc_shortdescription";

# Make it works
- The module does not need to be activated by Admin

1)    
- In Simple Product switch Yes/No the attribute 'CUSTOM CATALOG: Description from Configurable'
- In Simple Product switch Yes/No the attribute 'CUSTOM CATALOG: Short Description from Configurable'
- For new product these attributes are default on 'Yes'
