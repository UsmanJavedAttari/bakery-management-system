--
-- Database: `bakery`
--

DROP DATABASE IF EXISTS `bakery`;
CREATE DATABASE IF NOT EXISTS `bakery`;
USE `bakery`;

-- --------------------------------------------------------

--
-- Table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `Id` varchar(36) NOT NULL,
  `CustomerId` varchar(36) NOT NULL,
  PRIMARY KEY (`Id`,`CustomerId`)
);

-- --------------------------------------------------------

--
-- Table `cartitem`
--

DROP TABLE IF EXISTS `cartitem`;
CREATE TABLE IF NOT EXISTS `cartitem` (
  `CartId` varchar(36) NOT NULL,
  `ProductId` varchar(36) NOT NULL,
  `Quantity` float NOT NULL,
  PRIMARY KEY (`CartId`,`ProductId`)
);

-- --------------------------------------------------------

--
-- Table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `Id` varchar(36) NOT NULL,
  `DisplayName` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(80) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Email` (`Email`)
);

-- --------------------------------------------------------

--
-- Table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `Id` varchar(36) NOT NULL,
  `CustomerId` varchar(36) NOT NULL,
  `CreatedAt` datetime NOT NULL,
  PRIMARY KEY (`Id`)
);

-- --------------------------------------------------------

--
-- Table `orderdetail`
--

DROP TABLE IF EXISTS `orderdetail`;
CREATE TABLE IF NOT EXISTS `orderdetail` (
  `Id` varchar(36) NOT NULL,
  `OrderId` varchar(36) NOT NULL,
  `ProductId` varchar(36) NOT NULL,
  `UnitPrice` float NOT NULL,
  `Quantity` float NOT NULL,
  PRIMARY KEY (`Id`)
);

-- --------------------------------------------------------

--
-- Table `paymentaccount`
--

DROP TABLE IF EXISTS `paymentaccount`;
CREATE TABLE IF NOT EXISTS `paymentaccount` (
  `PaymentCardNumber` int(8) NOT NULL,
  `CustomerId` varchar(36) NOT NULL,
  PRIMARY KEY (`PaymentCardNumber`)
);

-- --------------------------------------------------------

--
-- Table `paymentinvoice`
--

DROP TABLE IF EXISTS `paymentinvoice`;
CREATE TABLE IF NOT EXISTS `paymentinvoice` (
  `Id` varchar(36) NOT NULL,
  `OrderId` varchar(36) NOT NULL,
  `AmountCharged` float NOT NULL,
  `PaymentCardNumber` int(8) NOT NULL,
  `GeneratedAt` datetime NOT NULL,
  PRIMARY KEY (`Id`)
);

-- --------------------------------------------------------

--
-- Table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `Id` varchar(36) NOT NULL,
  `Title` varchar(120) NOT NULL,
  `Description` text NOT NULL,
  `Price` float NOT NULL,
  `Quantity` float NOT NULL,
  `ProductCategoryId` varchar(36) NOT NULL,
  PRIMARY KEY (`Id`)
);

--
-- Data insertion for `product`
--

INSERT INTO `product` (`Id`, `Title`, `Description`, `Price`, `Quantity`, `ProductCategoryId`) VALUES
('106fa418-aa86-4dbe-8be6-138b5e447cfd', 'Milky Bread', 'Integer sollicitudin congue dolor, a pulvinar elit tristique eu. Maecenas varius sem ac congue aliquet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi laoreet sodales risus, a lacinia purus placerat in. Quisque at lectus eget sapien aliquam semper. Vivamus vitae dignissim arcu. Integer laoreet nisi tortor, commodo vestibulum justo consectetur eget. Suspendisse potenti. Etiam maximus libero sem, sit amet dapibus nunc dapibus a. Etiam consequat efficitur dignissim. Maecenas quis massa enim. Quisque placerat ut tellus nec placerat. Quisque ultrices urna a nisl fringilla condimentum. Donec commodo lorem a dapibus tincidunt. Nullam eros odio, ultricies blandit vehicula a, auctor vitae ex. Praesent blandit, urna eget condimentum mattis, erat risus molestie leo, sed auctor urna metus id nulla.', 223.54, 42, '01c62118-a105-4409-9623-f70092146379'),
('a1568055-096b-4eff-858d-87a9ce73226e', 'Test  Egg', 'Nullam risus felis, iaculis et condimentum rhoncus, gravida nec sem. Suspendisse volutpat, sem pharetra aliquam interdum, massa lectus sagittis eros, sed bibendum dui purus id orci. Donec sed pellentesque ipsum. Vivamus euismod fringilla odio non ullamcorper. Vivamus faucibus ornare tristique. Fusce scelerisque metus velit, id dignissim tortor efficitur at. Donec sollicitudin vel justo at tempus. Ut sed tortor ac ipsum rutrum tincidunt. Vestibulum bibendum gravida tortor eu cursus. Curabitur nec dignissim metus. Nulla ut nulla non metus aliquam ullamcorper non eu purus. Phasellus massa sem, interdum in auctor id, posuere in erat. Quisque aliquet dui non neque pretium, nec consectetur magna lacinia. Donec eu nunc a purus pulvinar rhoncus. Nam in leo sollicitudin, fringilla ipsum eget, pulvinar augue.', 857, 0, '78ad885c-fdb4-421c-becd-f862ed835fdc'),
('a1fe271e-545f-4cf8-a93f-02957dc1e904', 'Red Bread', 'Cras ultrices sed augue rhoncus dictum. Interdum et malesuada fames ac ante ipsum primis in faucibus. In id aliquam massa, sit amet convallis mauris. Pellentesque congue nibh magna, ut feugiat nunc efficitur sit amet. Proin a orci tortor. Proin convallis ante eu sapien hendrerit semper ut id nulla. Curabitur ut dignissim tortor, quis volutpat ex. Vestibulum viverra volutpat volutpat. Donec tempor nibh eu efficitur gravida. Nunc bibendum, risus non varius volutpat, ligula sem ultricies odio, id sollicitudin quam lectus sit amet mauris. Ut in ornare dui. Curabitur eleifend libero at quam tempor, et fermentum ipsum consequat. Phasellus non urna ante.', 642, 576, '01c62118-a105-4409-9623-f70092146379'),
('a380066c-ace0-4623-abcf-a6d7967f7c39', 'Green Bread', 'Curabitur vestibulum sagittis nibh, non feugiat nulla elementum vel. Quisque fermentum, elit sit amet posuere scelerisque, purus urna faucibus urna, vitae condimentum ipsum nulla sed lorem. Aenean leo diam, consequat at viverra quis, congue vitae purus. Maecenas tincidunt eget quam at lacinia. Nullam pulvinar maximus leo, a lobortis turpis. Nulla erat augue, sodales in nulla et, euismod vehicula quam. Praesent nunc est, facilisis vel sapien rutrum, sagittis ornare dui. Sed efficitur urna ipsum, a efficitur urna finibus eget.', 998, 346, '01c62118-a105-4409-9623-f70092146379'),
('ae69ad40-82ee-4bf6-856c-26708074083a', 'Blue Bread', 'Quisque vel dui vehicula, euismod mi sit amet, fermentum justo. Mauris non nibh et ante maximus tincidunt ac vel nisi. Integer eget tempor nibh, ut euismod ante. Suspendisse aliquam rhoncus tortor, tristique suscipit velit vestibulum ac. Pellentesque sed tortor quis lectus mollis fermentum ac ac elit. Praesent elementum sollicitudin magna sollicitudin varius. Aliquam rhoncus nec lorem eu rutrum.', 591, 403, '01c62118-a105-4409-9623-f70092146379'),
('c4451656-bbde-401c-94a9-74d488b53d75', 'Random Bread', 'Suspendisse sagittis interdum velit sed iaculis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis aliquet est et diam iaculis fringilla. Morbi viverra felis at tempus hendrerit. Quisque sed tellus in felis laoreet placerat posuere sed sem. Donec accumsan augue leo, et fermentum nulla pretium convallis. Ut interdum velit eget pulvinar rutrum. Cras eget bibendum mi. Nunc euismod ullamcorper varius.', 310, 301, '01c62118-a105-4409-9623-f70092146379'),
('cd54dbdd-aeed-4f63-a90d-d039853e1f5b', 'Tutti Fruti Bread', 'Vestibulum pharetra consectetur ligula, ut congue elit. Nullam porttitor orci mollis, ullamcorper lectus viverra, imperdiet elit. Cras eget augue quis sapien ultricies sagittis vitae in enim. Sed vel venenatis sem. Aliquam vitae gravida ante, in euismod nulla. Aenean sed finibus nisl. Ut blandit porttitor tortor in mollis. Nunc in erat id metus vulputate viverra et eu lorem. Donec sed luctus dolor, in ullamcorper risus. Fusce sed suscipit erat.', 515, 337, '01c62118-a105-4409-9623-f70092146379'),
('e1eed67e-ce56-4249-b393-84225fcbed60', 'New Egg', 'Nulla quis eleifend leo, vitae facilisis lacus. Nullam placerat massa eget interdum tincidunt. Maecenas ut elementum est, at auctor mi. Sed aliquet convallis justo, eget aliquam sapien ultricies sed. Nunc fringilla ac massa et ultrices. Maecenas bibendum volutpat mi, at interdum magna pellentesque ut. Nam varius nulla sit amet ligula tincidunt, at vehicula mauris egestas. Ut luctus tincidunt justo, ac ultricies magna gravida vitae. Aenean facilisis dui magna, vitae euismod elit malesuada id. Vestibulum tincidunt porttitor ex, nec eleifend ligula dapibus vitae. Vivamus non pulvinar leo. Nam id tortor purus. Fusce venenatis, mauris eget pharetra molestie, ex nulla condimentum risus, a ornare felis quam vitae diam. Proin consectetur tempus orci id elementum. Donec lectus tellus, dapibus vel egestas vel, aliquet ut erat.', 870, 173, '78ad885c-fdb4-421c-becd-f862ed835fdc'),
('ead03e48-2616-4ee2-9591-bd4bfbdd1bcf', 'Unique Bread', 'Pellentesque quis sem in nulla pellentesque ultrices. Morbi posuere, diam sed scelerisque iaculis, sem tortor porttitor eros, quis congue nisi justo ac nibh. Integer scelerisque risus felis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris fringilla tempus cursus. Quisque erat nibh, efficitur pulvinar magna tincidunt, semper venenatis dolor. Fusce egestas magna tellus, vitae sagittis nulla finibus vitae. Proin augue metus, volutpat non urna a, sagittis auctor purus. Etiam ac nunc nec turpis malesuada finibus. Pellentesque semper, augue tincidunt sodales ultrices, nibh erat ultrices erat, id facilisis tortor ante sed justo. Curabitur volutpat mauris nec pulvinar tristique. Pellentesque venenatis ipsum vel dapibus luctus. Nulla nec nunc mollis, condimentum nulla ut, laoreet odio.', 575, 561, '01c62118-a105-4409-9623-f70092146379'),
('ee499703-9ab8-430d-9683-3042a15473e6', 'Simple Egg', 'Nam feugiat orci nisl, eget commodo lorem tempor vel. Donec ac dolor molestie, vehicula quam id, ultricies eros. Nam justo turpis, mollis non scelerisque ut, vulputate nec sapien. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce ullamcorper nisl sit amet malesuada molestie. Donec mattis dolor neque, pretium accumsan tortor elementum at. Fusce fringilla nulla purus, ut porttitor orci feugiat sit amet. Suspendisse non fringilla nisi, ut ullamcorper arcu. Curabitur iaculis eu enim non aliquet. Nullam condimentum velit at nisi consequat imperdiet. Curabitur molestie bibendum elit sed ultricies. Quisque a enim sed ipsum consectetur rhoncus vitae eu erat.', 868, 416, '78ad885c-fdb4-421c-becd-f862ed835fdc');

-- --------------------------------------------------------

--
-- Table `productcategory`
--

DROP TABLE IF EXISTS `productcategory`;
CREATE TABLE IF NOT EXISTS `productcategory` (
  `Id` varchar(36) NOT NULL,
  `Title` varchar(120) NOT NULL,
  `Description` text NOT NULL,
  PRIMARY KEY (`Id`)
);

--
-- Data insertion for `productcategory`
--

INSERT INTO `productcategory` (`Id`, `Title`, `Description`) VALUES
('01c62118-a105-4409-9623-f70092146379', 'Bread', 'Bread is a staple food prepared from a dough of flour and water, usually by baking. Throughout recorded history it has been a prominent food in large parts of the world.'),
('78ad885c-fdb4-421c-becd-f862ed835fdc', 'Egg', 'Eggs are laid by female animals of many different species, including birds, reptiles, amphibians, a few mammals, and fish, and many of these have been eaten by humans for thousands of years. Bird and reptile eggs consist of a protective eggshell, albumen, and vitellus, contained within various thin membranes.');

--
-- `cart` Foreign keys
--

ALTER TABLE `cart` ADD FOREIGN KEY (`CustomerId`) REFERENCES `customer` (`Id`);

--
-- `cartitem` Foreign keys
--

ALTER TABLE `cartitem` ADD FOREIGN KEY (`CartId`) REFERENCES `cart` (`Id`);
ALTER TABLE `cartitem` ADD FOREIGN KEY (`ProductId`) REFERENCES `product` (`Id`);

--
-- `order` Foreign keys
--

ALTER TABLE `order` ADD FOREIGN KEY (`CustomerId`) REFERENCES `customer` (`Id`);

--
-- `orderdetail` Foreign keys
--

ALTER TABLE `orderdetail` ADD FOREIGN KEY (`OrderId`) REFERENCES `order` (`Id`);
ALTER TABLE `orderdetail` ADD FOREIGN KEY (`ProductId`) REFERENCES `product` (`Id`);

--
-- `paymentaccount` Foreign keys
--

ALTER TABLE `paymentaccount` ADD FOREIGN KEY (`CustomerId`) REFERENCES `customer` (`Id`);

--
-- `paymentinvoice` Foreign keys
--

ALTER TABLE `paymentinvoice` ADD FOREIGN KEY (`PaymentCardNumber`) REFERENCES `paymentaccount` (`PaymentCardNumber`);

--
-- `product` Foreign keys
--

ALTER TABLE `product` ADD FOREIGN KEY (`ProductCategoryId`) REFERENCES `productcategory` (`Id`);