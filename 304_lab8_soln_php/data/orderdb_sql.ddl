DROP TABLE review;
DROP TABLE shipment;
DROP TABLE productinventory;
DROP TABLE warehouse;
DROP TABLE orderproduct;
DROP TABLE incart;
DROP TABLE product;
DROP TABLE category;
DROP TABLE ordersummary;
DROP TABLE paymentmethod;
DROP TABLE customer;
DROP TABLE administrator;

CREATE TABLE administrator (
    administratorId     INT IDENTITY,
    adminid             VARCHAR(20),
    password            VARCHAR(30),
    PRIMARY KEY (administratorId)
);

CREATE TABLE customer (
    customerId          INT IDENTITY,
    firstName           VARCHAR(40),
    lastName            VARCHAR(40),
    email               VARCHAR(50),
    phonenum            VARCHAR(20),
    address             VARCHAR(50),
    city                VARCHAR(40),
    state               VARCHAR(20),
    postalCode          VARCHAR(20),
    country             VARCHAR(40),
    userid              VARCHAR(20),
    password            VARCHAR(30),
    PRIMARY KEY (customerId)
);

CREATE TABLE paymentmethod (
    paymentMethodId     INT IDENTITY,
    paymentType         VARCHAR(20),
    paymentNumber       VARCHAR(30),
    paymentExpiryDate   DATE,
    customerId          INT,
    PRIMARY KEY (paymentMethodId),
    FOREIGN KEY (customerId) REFERENCES customer(customerid)
        ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE ordersummary (
    orderId             INT IDENTITY,
    orderDate           DATETIME,
    totalAmount         DECIMAL(10,2),
    shiptoAddress       VARCHAR(50),
    shiptoCity          VARCHAR(40),
    shiptoState         VARCHAR(20),
    shiptoPostalCode    VARCHAR(20),
    shiptoCountry       VARCHAR(40),
    customerId          INT,
    PRIMARY KEY (orderId),
    FOREIGN KEY (customerId) REFERENCES customer(customerid)
        ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE category (
    categoryId          INT IDENTITY,
    categoryName        VARCHAR(50),    
    PRIMARY KEY (categoryId)
);

CREATE TABLE product (
    productId           INT IDENTITY,
    productName         VARCHAR(40),
    productPrice        DECIMAL(10,2),
    productImageURL     VARCHAR(100),
    productImage        VARBINARY(MAX),
    productDesc         VARCHAR(1000),
    categoryId          INT,
    PRIMARY KEY (productId),
    FOREIGN KEY (categoryId) REFERENCES category(categoryId)
);

CREATE TABLE orderproduct (
    orderId             INT,
    productId           INT,
    quantity            INT,
    price               DECIMAL(10,2),  
    PRIMARY KEY (orderId, productId),
    FOREIGN KEY (orderId) REFERENCES ordersummary(orderId)
        ON UPDATE CASCADE ON DELETE NO ACTION,
    FOREIGN KEY (productId) REFERENCES product(productId)
        ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE incart (
    orderId             INT,
    productId           INT,
    quantity            INT,
    price               DECIMAL(10,2),  
    PRIMARY KEY (orderId, productId),
    FOREIGN KEY (orderId) REFERENCES ordersummary(orderId)
        ON UPDATE CASCADE ON DELETE NO ACTION,
    FOREIGN KEY (productId) REFERENCES product(productId)
        ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE warehouse (
    warehouseId         INT IDENTITY,
    warehouseName       VARCHAR(30),    
    PRIMARY KEY (warehouseId)
);

CREATE TABLE shipment (
    shipmentId          INT IDENTITY,
    shipmentDate        DATETIME,   
    shipmentDesc        VARCHAR(100),   
    warehouseId         INT, 
    PRIMARY KEY (shipmentId),
    FOREIGN KEY (warehouseId) REFERENCES warehouse(warehouseId)
        ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE productinventory ( 
    productId           INT,
    warehouseId         INT,
    quantity            INT,
    price               DECIMAL(10,2),  
    PRIMARY KEY (productId, warehouseId),   
    FOREIGN KEY (productId) REFERENCES product(productId)
        ON UPDATE CASCADE ON DELETE NO ACTION,
    FOREIGN KEY (warehouseId) REFERENCES warehouse(warehouseId)
        ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE review (
    reviewId            INT IDENTITY,
    reviewRating        INT,
    reviewDate          DATETIME,   
    customerId          INT,
    productId           INT,
    reviewComment       VARCHAR(1000),          
    PRIMARY KEY (reviewId),
    FOREIGN KEY (customerId) REFERENCES customer(customerId)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (productId) REFERENCES product(productId)
        ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO category(categoryName) VALUES ('Consoles');
INSERT INTO category(categoryName) VALUES ('Accessories');
INSERT INTO category(categoryName) VALUES ('Rouge-Like');
INSERT INTO category(categoryName) VALUES ('Local Multiplayer');
INSERT INTO category(categoryName) VALUES ('Simulator');
INSERT INTO category(categoryName) VALUES ('Violent');
INSERT INTO category(categoryName) VALUES ('Horror');
INSERT INTO category(categoryName) VALUES ('Online Multiplayer');
INSERT INTO category(categoryName) VALUES ('Bullet Hell');
INSERT INTO category(categoryName) VALUES ('Simulator');
INSERT INTO category(categoryName) VALUES ('Story Heavy');
INSERT INTO category(categoryName) VALUES ('Survival');
INSERT INTO category(categoryName) VALUES ('platformer');

INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Hollow Knight', 3, 'Forge your own path in Hollow Knight!
 An epic action adventure through a vast ruined kingdom of insects and heroes.
  Explore twisting caverns, battle tainted creatures and befriend bizarre bugs, all in a classic, hand-drawn 2D style.',16.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Bad North',12,'Bad North is a charming but brutal real-time tactics roguelite.
 Defend your idyllic island kingdom against a horde of Viking invaders, as you lead the desperate exodus of your people.
  Command your loyal subjects to take full tactical advantage of the unique shape of each island.',20.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('The Binding of Isaac: Rebirth',3,'The Binding of Isaac: Rebirth
 is a randomly generated action RPG shooter with heavy Rogue-like elements. Following Isaac on his journey players will find bizarre treasures
  that change Isaac’s form giving him super human abilities and enabling him to fight off droves of mysterious creatures',16.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Celeste',13,'Help Madeline survive her inner demons on her journey to the top of Celeste Mountain,
 in this super-tight platformer from the creators of TowerFall. Brave hundreds of hand-crafted challenges, uncover devious secrets,
  and piece together the mystery of the mountain.',21.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Crawl',4,'Crawl is the local multiplayer dungeon crawler
 where your friends control the monsters! Battle through dungeons and power up your hero
 - if a friend kills you they take your place and it’s their turn to crawl.
  It is a race to gain enough XP and loot to take on the hulking final boss!',16.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Do Not Feed The Monkeys',5,'A digital voyeur simulator
 where you watch strangers through surveillance cameras. Invade their privacy and witness their most intimate moments,
  but don’t interact with the subjects – anything could happen if you dare feed the monkeys!',12.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Enter The Gungeon',9,'Enter the Gungeon is a bullet hell dungeon crawler
 following a band of misfits seeking to shoot, loot, dodge roll and table-flip their way to personal absolution
  by reaching the legendary Gungeon’s ultimate treasure: the gun that can kill the past.',16.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Hotline Miami',6,'Hotline Miami is a high-octane action game
 overflowing with raw brutality, hard-boiled gunplay and skull crushing close combat.',10.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Noita',3,'Noita is a magical action roguelite set in a world where every pixel is physically simulated.
 Fight, explore, melt, burn, freeze and evaporate your way through the procedurally generated world using spells you have created yourself.',22.79);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Sea Salt',7,'Sea Salt is a dark fantasy reverse horror action-strategy game
 where you play as the nightmarish force of Dagon by controlling and growing a horde of minions.',17.49);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Among Us',8,'An online and local party game of teamwork and betrayal
 for 4-10 players...in space!',5.69);
 INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Cuphead',9,'Cuphead is a classic run and gun action game heavily
 focused on boss battles. Inspired by cartoons of the 1930s, the visuals and audio are painstakingly created with the same techniques of the era,
  i.e. traditional hand drawn cel animation, watercolor backgrounds, and original jazz recordings.',21.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Despotism 3k',12,'Humanity is enslaved by an AI… which is awesome,
 because we are on the right side of the conflict. Exploit puny humans to extract power and build your own empire!',8.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Gris',13,'Gris is a hopeful young girl lost in her own world,
 dealing with a painful experience in her life. Her journey through sorrow is manifested in her dress,
  which grants new abilities to better navigate her faded reality.',19.49);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Kingdom: Two Crowns',12,'In Kingdom Two Crowns,
 players must work in the brand-new solo or co-op campaign mode to build their kingdom and secure it from the threat of the Greed.
  Experience new technology, units, enemies, mounts, and secrets in the next evolution of the award-winning micro strategy franchise!',22.79);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Mafia: Definitive Edition',11,'An inadvertent brush with the mob
 thrusts cabdriver Tommy Angelo into the world of organized crime. Initially uneasy about falling in with the Salieri family,
  the rewards become too big to ignore.',49.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Mafia II: Definitive Edition',11,'War hero Vito Scaletta becomes
 entangled with the mob in hopes of paying his fathers debts. Vito works to prove himself,
  climbing the family ladder with crimes of larger reward and consequence.',29.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Mafia III: Definitive Edition',11,'After Lincoln Clays surrogate family,
 the black mob, is betrayed and killed by the Italian Mafia,
  Lincoln builds a new family and blazes a path of revenge through the Mafioso responsible.',29.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Dont Starve',12,'Dont Starve is an uncompromising wilderness survival
 game full of science and magic. Enter a strange and unexplored world full of strange creatures, dangers, and surprises.
  Gather resources to craft items and structures that match your survival style.',11.49);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Cyberpunk 2077',6,'Cyberpunk 2077 is an open-world,
 action-adventure story set in Night City, a megalopolis obsessed with power, glamour and body modification.
  You play as V, a mercenary outlaw going after a one-of-a-kind implant that is the key to immortality.',79.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Katana ZERO',13,'Katana ZERO is a stylish neo-noir,
 action-platformer featuring breakneck action and instant-death combat. Slash, dash,
  and manipulate time to unravel your past in a beautifully brutal acrobatic display.',17.49);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Cities: Skylines',10,'Cities: Skylines is a modern take on the classic city
 simulation. The game introduces new game play elements to realize the thrill and hardships of creating and maintaining a real city whilst
  expanding on some well-established tropes of the city building experience.',32.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Hollow Knight: Silk Song',3,'Discover a vast, haunted kingdom
 in Hollow Knight: Silksong! The sequel to the award winning action-adventure. Explore, fight and survive as you ascend to the peak
  of a land ruled by silk and song.',20.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('XBox',1,'The Xbox is a home video game console and the first installment
 in the Xbox series of video game consoles manufactured by Microsoft. It was released as Microsofts first foray into the gaming console market
  on November 15, 2001, in North America, followed by Australia, Europe and Japan in 2002.
   It is classified as a sixth-generation console, competing with the PlayStation 2 and the GameCube.
    It was also the first major console produced by an American company since the release of the Atari Jaguar in 1993.',299.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('XBox 360',1,'The Xbox 360 is a home video game console developed
 by Microsoft. As the successor to the original Xbox, it is the second console in the Xbox series.
  It competed with the PlayStation 3 and the Wii as part of the seventh generation of video game consoles.
   It was officially unveiled on MTV on May 12, 2005, with detailed launch and game information announced later that month at the
    2005 Electronic Entertainment Expo.',399.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('XBox One',1,'Own the Xbox One S 1TB Console and get access to over
 1,300 games that you can only play on Xbox One. Play with friends near and far and enjoy the highest quality 4K including built-in 4K
  Ultra HD Blu-ray and 4K video streaming. Xbox Play Anywhere games let you play at a friends house and then pick up where you left off
   on any Xbox One or Windows 10 PC. Xbox One delivers brilliant graphics with HDR technology, premium audio, and fast, reliable online
    gaming with friends. Access all your favorite entertainment through apps like YouTube, Netflix, and more.
     Whether you’re playing with instant access to over 100 games on Xbox Game Pass, watching 4K movies, or streaming live gameplay.',499.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('XBox X',1,'Introducing Xbox Series X, the fastest,
 most powerful Xbox ever. Play thousands of titles from four generations of consoles—all games look and play best on Xbox Series X.
  At the heart of Series X is the Xbox Velocity Architecture, which pairs a custom SSD with integrated software for faster,
   streamlined gameplay with significantly reduced load times. Seamlessly move between multiple games in a flash with Quick Resume.
    Explore rich new worlds and enjoy the action like never before with the unmatched 12 teraflops of raw graphic processing power.
     Enjoy 4K gaming at up to 120 frames per second, advanced 3D spatial sound, and more.
      Get started with an instant library of 100+ high-quality games,
       including all new Xbox Game Studios titles the day they launch like Halo Infinite',599.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('PS1',1,'a home video game console developed
 and marketed by Sony Computer Entertainment. It was first released on 3 December 1994 in Japan, 9 September 1995 in North America,
  29 September 1995 in Europe, and 15 November 1995 in Australia, and was the first of the PlayStation lineup of video game consoles.
   As a fifth generation console, the PlayStation primarily competed with the Nintendo 64 and the Sega Saturn.',299.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('PS2',1,'The PlayStation 2 (PS2) is a 
home video game console developed and marketed by Sony Computer Entertainment. It was first released in Japan on March 4, 2000,
 in North America on October 26, 2000, in Europe on November 24, 2000, and Australia on November 24, 2000. It is the successor to the
  original PlayStation, as well as the second installment in the PlayStation console line-up. A sixth-generation console, it competed with
   the Dreamcast, GameCube, and the original Xbox.',299.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('PS3',1,'PlayStation 3 (PS3) is a home video game console
 developed by Sony Computer Entertainment. It is the successor to PlayStation 2, and is part of the PlayStation brand of consoles. It was first
  released on November 11, 2006 in Japan. November 17, 2006 in North America, and March 23, 2007 in Europe and Australia.
   The PlayStation 3 competed primarily against the Xbox 360 and the Wii as part of the seventh generation of video game consoles.',499.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('PS4',1,'PlayStation 4 (PS4) is a home video game console
 developed by Sony Computer Entertainment. Announced as the successor to the PlayStation 3 in February 2013, it was launched on November 15, 2013,
  in North America, November 29, 2013 in Europe, South America and Australia, and on February 22, 2014 in Japan. A console of the eighth generation,
   it competes with the Xbox One, the Wii U and Switch.',399.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('PS5',1,'PlayStation 5 (PS5) is a home video game console
 developed by Sony Interactive Entertainment. Announced in 2019 as the successor to the PlayStation 4, the PS5 was released on November 12,
  2020 in Australia, Japan, New Zealand, North America, Singapore, and South Korea, and November 19, 2020 onwards in other major markets except
   China and India.',499.99);

INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('XBox Controller', 2, 'Controller for the original Xbox',89.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('XBox 360 Controller', 2, 'Controller for the Xbox 360',74.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('XBox One Controller', 2, 'Controller for the Xbox One',69.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('XBox X Controller', 2, 'Controller for the Xbox X',74.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('PS1 Controller', 2, 'Controller for the original PlayStation',75.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('PS2 Controller', 2, 'Controller for the PS2',42.50);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('PS3 Controller', 2, 'Controller for the PS3',39.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('PS4 Controller', 2, 'Controller for the PS4',74.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('PS5 Controller', 2, 'Controller for the PS5',89.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('RGB Keyboard', 2, 'Mechanical RGB keyboard',139.99);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('RGB Mouse', 2, 'RGB mouse',99.99);

INSERT INTO warehouse(warehouseName) VALUES ('Main warehouse');
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (1, 1, 5, 16.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (2, 1, 10, 20.00);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (3, 1, 3, 16.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (4, 1, 2, 21.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (5, 1, 6, 16.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (6, 1, 3, 12.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (7, 1, 1, 16.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (8, 1, 0, 10.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (9, 1, 2, 22.79);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (10, 1, 3, 17.49);

INSERT INTO warehouse(warehouseName) VALUES ('Second warehouse');
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (2, 2, 10, 20.00);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (3, 2, 31, 16.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (4, 2, 12, 21.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (5, 2, 6, 16.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (6, 2, 3, 12.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (7, 2, 17, 16.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (8, 2, 0, 10.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (9, 2, 2, 22.79);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (10, 2, 13, 17.49);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (11, 2, 1, 5.69);

INSERT INTO warehouse(warehouseName) VALUES ('Third warehouse');
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (5, 3, 6, 16.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (6, 3, 13, 12.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (7, 3, 1, 16.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (8, 3, 0, 10.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (9, 3, 2, 22.79);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (10, 3, 13, 17.49);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (11, 3, 5, 5.69);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (12, 3, 10, 21.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (13, 3, 13, 8.99);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (14, 3, 2, 19.49);

INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Arnold', 'Anderson', 'a.anderson@gmail.com', '204-111-2222', '103 AnyWhere Street', 'Winnipeg', 'MB', 'R3X 45T', 'Canada', 'arnold' , 'test');
INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Bobby', 'Brown', 'bobby.brown@hotmail.ca', '572-342-8911', '222 Bush Avenue', 'Boston', 'MA', '22222', 'United States', 'bobby' , 'bobby');
INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Candace', 'Cole', 'cole@charity.org', '333-444-5555', '333 Central Crescent', 'Chicago', 'IL', '33333', 'United States', 'candace' , 'password');
INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Darren', 'Doe', 'oe@doe.com', '250-807-2222', '444 Dover Lane', 'Kelowna', 'BC', 'V1V 2X9', 'Canada', 'darren' , 'pw');
INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Elizabeth', 'Elliott', 'engel@uiowa.edu', '555-666-7777', '555 Everwood Street', 'Iowa City', 'IA', '52241', 'United States', 'beth' , 'test');

-- Order 1 can be shipped as have enough inventory
DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (1, '2019-10-15 10:25:55', 91.70)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 1, 1, 18)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 5, 2, 21.35)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 10, 1, 31);

DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (2, '2019-10-16 18:00:00', 106.75)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 5, 5, 21.35);

-- Order 3 cannot be shipped as do not have enough inventory for item 7
DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (3, '2019-10-15 3:30:22', 140)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 6, 2, 25)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 7, 3, 30);

DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (2, '2019-10-17 05:45:11', 327.85)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 3, 4, 10)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 8, 3, 40)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 13, 3, 23.25)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 28, 2, 21.05)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 29, 4, 14);

DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (5, '2019-10-15 10:25:55', 277.40)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 5, 4, 21.35)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 19, 2, 81)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 20, 3, 10);

INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (9,'2019-11-15 3:30:22', 1, 1, 'It's a deep dive into a dark place, and a brilliantly rich experience.');
INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (10,'2019-10-13 3:50:22', 2, 1, 'Truly a masterpiece of gaming if there ever was one, and certainly art worthy of being in a museum.');
INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (9,'2019-10-15 3:30:25', 3, 1, 'Best Platformer 2017 - The joy of Hollow Knight is the joy of discovery, always hard-earned, never handed to you.');
INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (10,'2019-11-15 3:30:22', 4, 1, 'Absolutely stunning game. From its story, to gameplay, to sound-design and to its beautifully well-made art, Hollow Knight makes for a heavily enjoyable Metroidvania where one can expect to face tough challenges in quite an eerie yet cozy environment. The combat always stays exciting, addicting and is well-crafted. The more solid-colour characters blend in with the shaded depth of the backgrounds - while each area, its level-design and the enemies always give a feeling of fresh wonderment when progressing through the game. The free DLC, on top of this, are very entertaining bonuses to the overall content.');
INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (9,'2019-10-13 3:50:22', 5, 1, 'Beautiful. Atmospheric. INFURIATING.');
INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (7,'2019-11-15 3:30:22', 1, 2, 'The game itself is pretty unique and surprisingly fun for a few hours. It's challenging but becomes repetitive after some time. I think i came for the unique graphics theme but i stayed because of the music and sound effects. It's perfect.');
INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (4,'2019-10-13 3:50:22', 2, 2, 'Great little game, but way too simple & too little content for the price. Still not refunding it because I like to support these guys.');
INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (8,'2019-10-15 3:30:25', 3, 2, 'Great minimalist tactics game with suberb design! can get pretty hardcore, but you can enable options like restart level, so frustration can be avoided, while training for the real challenge.');
INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (10,'2019-11-15 3:30:22', 4, 2, 'Bad North follows a recent trend I like in indie games which is a good idea developed simply but flawlessly leading to a relatively short but incredibly enjoyable experience. 10/10 from me, I strongly recommend.');
INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (1,'2019-10-13 3:50:22', 5, 2, 'Very shallow game');
INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (8,'2019-11-15 3:30:22', 1, 3, 'This is probably the best bang for your buck that you will ever get, especially if you are a completionist');
INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (8,'2019-10-13 3:50:22', 2, 3, 'After somewhat thorough analysis, I can confirm that you can cry in this game. Which is the type of immersion I need this year.');
INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (10,'2019-10-15 3:30:25', 3, 3, 'After 2000 hours played (with a few hundred on the original Flash version) I guess I should write a review. This is a good game. I think you should buy it.');
INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (9,'2019-11-15 3:30:22', 4, 3, 'This is everything a remake should be: More items, more characters, more challenges, more bosses... More everything. My computer is old and chugs with games like Minecraft and Team Fortress 2, but Isaac: Rebirth runs silky smooth.');
INSERT INTO review(reviewRating, reviewDate, customerId, productId, reviewComment) VALUES (9,'2019-10-13 3:50:22', 5, 3, 'The Binding of Isaac: Rebirth Is One Of The Best Indie Game Of All Time!');

INSERT INTO administrator (adminid, password) VALUES ('admin', 'bob');
INSERT INTO administrator (adminid, password) VALUES ('admin2', 'bobo');

UPDATE Product SET productImageURL = 'img/HK.jpg' WHERE ProductName = 'Hollow Knight';
UPDATE Product SET productImageURL = 'img/Noita.jpg' WHERE ProductName = 'Noita';
UPDATE Product SET productImageURL = 'img/MDE.jpg' WHERE ProductName = 'Mafia: Definitive Edition';
UPDATE Product SET productImageURL = 'img/M2DE.jpg' WHERE ProductName = 'Mafia II: Definitive Edition';
UPDATE Product SET productImageURL = 'img/M3DE.jpg' WHERE ProductName = 'Mafia III: Definitive Edition';
UPDATE Product SET productImageURL = 'img/HM.jpg' WHERE ProductName = 'Hotline Miami';
UPDATE Product SET productImageURL = 'img/HKSS.jpg' WHERE ProductName = 'Hollow Knight: Silk Song';
UPDATE Product SET productImageURL = 'img/D3k.jpg' WHERE ProductName = 'Despotism 3k';
UPDATE Product SET productImageURL = 'img/CSL.jpg' WHERE ProductName = 'Cities: Skylines';
UPDATE Product SET productImageURL = 'img/BoI.jpg' WHERE ProductName = 'The Binding of Isaac: Rebirth';
UPDATE Product SET productImageURL = 'img/Crawl.jpg' WHERE ProductName = 'Crawl';
UPDATE Product SET productImageURL = 'img/CH.jpg' WHERE ProductName = 'Cuphead';
UPDATE Product SET productImageURL = 'img/BN.jpg' WHERE ProductName = 'Bad North';
UPDATE Product SET productImageURL = 'img/Celeste.jpg' WHERE ProductName = 'Celeste';
UPDATE Product SET productImageURL = 'img/DNFTM.jpg' WHERE ProductName = 'Do Not Feed The Monkeys';
UPDATE Product SET productImageURL = 'img/EtG.jpg' WHERE ProductName = 'Enter The Gungeon';
UPDATE Product SET productImageURL = 'img/SS.jpg' WHERE ProductName = 'Sea Salt';
UPDATE Product SET productImageURL = 'img/Among.jpg' WHERE ProductName = 'Among Us';
UPDATE Product SET productImageURL = 'img/CH.jpg' WHERE ProductName = 'Cuphead';
UPDATE Product SET productImageURL = 'img/Gris.jpg' WHERE ProductName = 'Gris';
UPDATE Product SET productImageURL = 'img/KTC.jpg' WHERE ProductName = 'Kingdom: Two Crowns';
UPDATE Product SET productImageURL = 'img/CP.jpg' WHERE ProductName = 'Cyberpunk 2077';
UPDATE Product SET productImageURL = 'img/Starve.jpg' WHERE ProductName = 'Dont Starve';
UPDATE Product SET productImageURL = 'img/KZ.jpg' WHERE ProductName = 'Katana ZERO';
UPDATE Product SET productImageURL = 'img/XBOX.jpg' WHERE ProductName = 'XBox';
UPDATE Product SET productImageURL = 'img/360.jpg' WHERE ProductName = 'Xbox 360';
UPDATE Product SET productImageURL = 'img/One.jpg' WHERE ProductName = 'XBox One';
UPDATE Product SET productImageURL = 'img/X.jpg' WHERE ProductName = 'XBox X';
UPDATE Product SET productImageURL = 'img/PS.jpg' WHERE ProductName = 'PS1';
UPDATE Product SET productImageURL = 'img/2.jpg' WHERE ProductName = 'PS2';
UPDATE Product SET productImageURL = 'img/3.jpg' WHERE ProductName = 'PS3';
UPDATE Product SET productImageURL = 'img/4.jpg' WHERE ProductName = 'PS4';
UPDATE Product SET productImageURL = 'img/5.jpg' WHERE ProductName = 'PS5';
UPDATE Product SET productImageURL = 'img/XBOXC.jpg' WHERE ProductName = 'XBox Controller';
UPDATE Product SET productImageURL = 'img/360C.jpg' WHERE ProductName = 'Xbox 360 Controller';
UPDATE Product SET productImageURL = 'img/OneC.jpg' WHERE ProductName = 'XBox One Controller';
UPDATE Product SET productImageURL = 'img/XC.jpg' WHERE ProductName = 'XBox X Controller';
UPDATE Product SET productImageURL = 'img/PSC.jpg' WHERE ProductName = 'PS1 Controller';
UPDATE Product SET productImageURL = 'img/2Con.jpg' WHERE ProductName = 'PS2 Controller';
UPDATE Product SET productImageURL = 'img/3C.jpg' WHERE ProductName = 'PS3 Controller';
UPDATE Product SET productImageURL = 'img/4C.jpg' WHERE ProductName = 'PS4 Controller';
UPDATE Product SET productImageURL = 'img/5C.jpg' WHERE ProductName = 'PS5 Controller';
UPDATE Product SET productImageURL = 'img/rgbKB.jpg' WHERE ProductName = 'RGB Keyboard';
UPDATE Product SET productImageURL = 'img/rgbMouse.jpg' WHERE ProductName = 'RGB Mouse';

