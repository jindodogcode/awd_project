# DATABASE SETUP

1. As a SuperUser account, run store-front-setup.sql  
    - This will create:  
        - Database: storefront  
        - User: storefrontadmin  
        - User: storefrontweb  

2. As a SuperUser account or the storefrontadmin account, run store-front-tables.sql  
    - This will create tables:  
        - Addresses  
        - Customers  
        - CustomerAddresses  
        - Payments  
        - Manufacturers  
        - ProductCategories  
        - Products  
        - CategorizedProducts  
        - ProductPictureURLs  
        - ProductSales  
        - Orders  
        - OrderProducts  

3. Run store-front-inserts.sql  
     - This will insert some basic product information  

4. To reset the database:  
     1. run store-front-drop-tables.sql  
     2. run store-front-tables.sql  
     3. run store-front-inserts.sql  


Included in the sql folder is an ER diagram of the database.  
