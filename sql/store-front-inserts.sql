INSERT INTO ProductCategories (name)
VALUES ('laptop');

INSERT INTO ProductCategories (name)
VALUES ('desktop');

INSERT INTO ProductCategories (name)
VALUES ('monitor');

INSERT INTO ProductCategories (name)
VALUES ('mouse');

INSERT INTO ProductCategories (name)
VALUES ('keyboard');

INSERT INTO Manufacturers (name)
VALUES ('Dell');

INSERT INTO Manufacturers (name)
VALUES ('Asus');

INSERT INTO Manufacturers (name)
VALUES ('Samsung');

INSERT INTO Manufacturers (name)
VALUES ('Lenovo');

INSERT INTO Products (manufacturer_id, name, price, info, description)
VALUES (
    (SELECT manufacturer_id FROM Manufacturers WHERE name = 'Dell'),
    'DELL laptop Vostro 9PJCR',
    849.71,
    '
    Intel Core i7 8th Gen 8565U (1.80 GHz)
    8 GB Memory 256 GB SSD
    NVIDIA GeForce MX130
    1920 x 1080
    Windows 10 Pro 64-bit
    ',
    '<h3>Dell Vostro 15 5000 Small Business Laptop</h3><br />
<p>A business-oriented 15-inch narrow-bezel laptop that combines robust performance, seamless connectivity and security options, creating a professional task master that keeps you productive at office or on the go.</p>
'
);

INSERT INTO ProductPictureURLs (product_id, url, alt_text)
VALUES (
    (SELECT product_id FROM Products WHERE name = 'DELL laptop Vostro 9PJCR'),
    './static/images/c0_Dell Vostro 15 5000 Small Business Laptop.jpg',
    'DELL Vostro laptop'
);

INSERT INTO CategorizedProducts (product_id, category_id)
VALUES (
    (SELECT product_id FROM Products WHERE name = 'DELL laptop Vostro 9PJCR'),
    (SELECT category_id FROM ProductCategories WHERE name = 'laptop')
);

INSERT INTO Products (manufacturer_id, name, price, info, description)
VALUES (
    (SELECT manufacturer_id FROM Manufacturers WHERE name = 'Asus'),
    'ASUS Laptop VivoBook F512DA-EB51',
    549.99,
    '
    AMD Ryzen 5 2nd Gen 3500U (2.10 GHz)
    8 GB Memory 256 GB SSD
    AMD Radeon Vega 8
    1920 x 1080
    Windows 10 Home 64-bit
    ',
    ''
);

INSERT INTO ProductPictureURLs (product_id, url, alt_text)
VALUES (
    (SELECT product_id FROM Products WHERE name = 'ASUS Laptop VivoBook F512DA-EB51'),
    './static/images/ASUS_laptop_vivobook_f512DA-eb51.jpg',
    'ASUS VivoBook'
);

INSERT INTO CategorizedProducts (product_id, category_id)
VALUES (
    (SELECT product_id FROM Products WHERE name = 'ASUS Laptop VivoBook F512DA-EB51'),
    (SELECT category_id FROM ProductCategories WHERE name = 'laptop')
);

INSERT INTO Products (manufacturer_id, name, price, info, description)
VALUES (
    (SELECT manufacturer_id FROM Manufacturers WHERE name = 'Samsung'),
    'Samsung Notebook Laptop 7 NP730QAA-K01US Spin',
    899.99,
    'Touch screen Samsung Notebook 7 Spin Convertible 2-in-1 Laptop: Experience the versatility of this 13.3-inch Samsung 2-in-1 laptop. Its Full HD touch screen display lets you interact with Windows 10',
    '<h3>Samsung Notebook 7 Spin</h3>
<h4>Spin to get things done your way</h4>

<p>Getting things done quickly and efficiently—that is what the Samsung Notebook 7 Spin is built for. 
Featuring a 360-degree hinge, it lets you spin easily from laptop to tablet mode or from tablet to notebook mode. 
The 13.3” touchscreen can work with a compatible active pen1 to deliver the most natural pen experience. 
With the 8th Gen Intel Core i5 processor and a long-lasting battery,2 Notebook 7 Spin helps you stay productive anywhere you go. Just carry out one-touch fingerprint access, and let the Notebook 7 Spin perform.</p>
'
);

INSERT INTO ProductPictureURLs (product_id, url, alt_text)
VALUES (
    (SELECT product_id FROM Products WHERE name = 'Samsung Notebook Laptop 7 NP730QAA-K01US Spin'),
    './static/images/samsung_notebook_laptop_7_np730qaa-k01us.jpg',
    'Samsung Notebook Laptop 7'
);

INSERT INTO CategorizedProducts (product_id, category_id)
VALUES (
    (SELECT product_id FROM Products WHERE name = 'Samsung Notebook Laptop 7 NP730QAA-K01US Spin'),
    (SELECT category_id FROM ProductCategories WHERE name = 'laptop')
);

INSERT INTO Products (manufacturer_id, name, price, info, description)
VALUES (
    (SELECT manufacturer_id FROM Manufacturers WHERE name = 'Dell'),
    'DELL Desktop Computer OptiPlex 3060 KM82W',
    643.99,
    '
    Intel Core i5 8th Gen 8500 (3.00 GHz)
    8 GB DDR4
    256 GB SSD
    Windows 10 Pro 64-bit
    No Screen
    Intel UHD Graphics 630
    ',
    ''
);

INSERT INTO ProductPictureURLs (product_id, url, alt_text)
VALUES (
    (SELECT product_id FROM Products WHERE name = 'DELL Desktop Computer OptiPlex 3060 KM82W'),
    './static/images/dell_optiplex3060_KM82W.jpg',
    'Dell OptiPlex 3060'
);

INSERT INTO CategorizedProducts (product_id, category_id)
VALUES (
    (SELECT product_id FROM Products WHERE name = 'DELL Desktop Computer OptiPlex 3060 KM82W'),
    (SELECT category_id FROM ProductCategories  WHERE name = 'desktop')
);

INSERT INTO Products (manufacturer_id, name, price, info, description)
VALUES (
    (SELECT manufacturer_id FROM Manufacturers WHERE name = 'Asus'),
    'ASUS (GL10CS)',
    809.99,
    '
    Intel Core i5-9400F (6-Core / 6-Thread, 2.9 GHz up to 4.1 GHz) CPU
    NVIDIA GeForce GTX 1660 (6 GB) GPU
    Intel B360 Chipset
    8 GB DDR4 Memory
    512 GB SSD
    500W 80+ Gold Power Supply
    Gigabit LAN & WI-Fi 5 (802.11ac) 2x2 + BT 5.0
    2 x USB 3.2 Gen 1 (front), 2 x USB 2.0, 2 x USB 3.2 Gen 1 (rear)
    1 x DVI, 1 x HDMI, 1 x DP
    Transparent Side Panel
    USB Keyboard, Mouse
    Windows 10 Home 64-bit
    ',
    ''
);

INSERT INTO ProductPictureURLs (product_id, url, alt_text)
VALUES (
    (SELECT product_id FROM Products WHERE name = 'ASUS (GL10CS)'),
    './static/images/asus_gl10cs.jpg',
    'ASUS gl10cs'
);

INSERT INTO CategorizedProducts (product_id, category_id)
VALUES (
    (SELECT product_id FROM Products WHERE name = 'ASUS (GL10CS)'),
    (SELECT category_id FROM ProductCategories WHERE name = 'desktop')
);

INSERT INTO Products (manufacturer_id, name, price, info, description)
VALUES (
    (SELECT manufacturer_id FROM Manufacturers WHERE name = 'Lenovo'),
    'Lenovo Desktop Computer ThinkCentre M710e',
    399.99,
    '
    Intel Core i3 7th Gen 7100 (3.90 GHz)
    4 GB DDR4
    1 TB HDD
    Windows 10 Pro 64-Bit
    No Screen
    Intel HD Graphics 630
    ',
    ''
);

INSERT INTO ProductPictureURLs (product_id, url, alt_text)
VALUES (
    (SELECT product_id FROM Products WHERE name = 'Lenovo Desktop Computer ThinkCentre M710e'),
    './static/images/lenovo_thinkcenter_m710e.jpg',
    'Lenovo ThinkCentre M710e'
);

INSERT INTO CategorizedProducts (product_id, category_id)
VALUES (
    (SELECT product_id FROM Products WHERE name = 'Lenovo Desktop Computer ThinkCentre M710e'),
    (SELECT category_id FROM ProductCategories WHERE name = 'desktop')
);
