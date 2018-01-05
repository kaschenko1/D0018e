-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 05, 2018 at 01:30 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `TestSchema`
--

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE `Comments` (
  `CommentID` int(11) NOT NULL,
  `CommentUserID` int(11) NOT NULL,
  `CommentMsg` varchar(200) DEFAULT NULL,
  `CommentProductID` int(11) NOT NULL,
  `Rating` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `OrderID` int(11) NOT NULL,
  `OrderUserID` int(11) NOT NULL,
  `OrderDate` datetime DEFAULT NULL,
  `OrderShipDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(45) DEFAULT NULL,
  `ProductPrice` varchar(45) DEFAULT NULL,
  `ProductPicture` varchar(45) DEFAULT NULL,
  `ProductDescription` varchar(255) DEFAULT NULL,
  `ProductStock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`ProductID`, `ProductName`, `ProductPrice`, `ProductPicture`, `ProductDescription`, `ProductStock`) VALUES
(21, 'Sony 75\'\' 4K UHD Smart TV KD-75XE8596\r\n', '22990', 'TV1.png', 'Sony', 25),
(22, 'LG 55\" 4K UHD LED Smart TV 55UJ701V', '6990', 'TV2.png', 'LG 55\" 4K UHD LED Smart TV 55UJ701V är en slimmad och läckert designad Smart-TV med Wi-Fi, 4K 2160p upplösning, WebOS 3.5, True Color Accuracy och Active HDR-teknologi som levererar varje detalj med a', 25),
(23, 'Samsung 49\" 4K UHD Smart TV UE49MU6195', '5990', 'TV3.png', 'Upplev fantastisk 4K UHD-bild utan att missa en enda detalj med Samsung 49\" 4K UHD Smart TV som också har naturtrogna färger och Tizen Smart Hub.', 25),
(24, 'Samsung 65\" 4K UHD Smart TV UE65MU7005', '16879', 'TV4.png', 'Samsung 65\" 4K UHD Smart TV UE65MU7005 imponerar med kristallklar bildkvalitet, 4K UHD 2160p upplösning.', 25),
(25, 'LG 65\" 4K UHD OLED Smart TV B7 OLED65B7V', '24890', 'TV5.png', 'Bli överraskad av LG 65\" 4K UHD OLED Smart TV OLED65B7V både när den är påslagen och avslagen. Med dess OLED panel och Active HDR garanteras en realistisk färgåtergivning.', 25),
(26, 'Samsung 55\" 4K UHD Smart TV QE55Q7FA', '16489', 'TV6.png', 'Samsung 55\" Q7F QLED 4K UHD Smart TV QE55Q7FAMT levererar den ljusstarkaste och skarpaste bildkvaliteten så långt. Titta på TV i strålande 4K UHD-kvalitet eller använd TV:n för att surfa på Internet, ladda ner och streama.', 25),
(27, 'Samsung 49\" 4K UHD Smart TV UE49MU9005', '12990', 'TV7.png', 'Samsung Curved 49\" 4K UHD Smart TV UE49MU9005 öppnar upp en helt ny värld av TV-underhållning i ditt hem. Upplev videokvalitet i enastående 4K UHD och njut av en fantastisk design som får TV:n att ver', 25),
(28, 'Samsung 55\" 4K UHD Smart TV UE55MU7075', '13990', 'TV8.png', 'Utforska en värld av smarta funktioner med Samsung UE55MU7075. Låt dig fångas av den kristallklara bildkvaliteten med imponerande svärta och vithetsgrad.', 25),
(29, 'Philips 43\'\' 4K UHD Smart TV 43PUS6162', '5790', 'TV9.png', 'Philips 43\'\' 4K UHD Smart TV 43PUS6162 är en smart-TV med 4K UHD 2160p-upplösning, fyrkärnig processor, 700 PPI och Wi-Fi.', 25),
(30, 'Philips 55\" 4K UHD LED Smart TV 55PUS8602/12', '17995', 'TV10.png', 'Philips 55 \" 4K UHD LED Smart- TV kombinerar Amblight-teknologi med Philips P5 och Android TV med Quod processor för att leverera optimal bild och underhållning.', 25),
(31, 'LG 60\" 4K Super UHD LED Smart TV 60SJ810V', '15490', 'TV11.png', 'LG 60\" 4K Super UHD LED Smart TV 60SJ810V får du en känsla av framtiden tack vare dess ultratunna och lätta design.', 25),
(32, 'LG 65\" 4K Super UHD LED Smart TV 65SJ850V', '17990', 'TV12.png', 'LG 65\" 4K Super UHD LED Smart TV 65SJ850V ger dig gränslösa möjligheter av streamingtjänster och appar på din TV:s stora skärm. Skärmen har en bildkvalitet på otroliga 4K UHD, otrolig färgåtergivning ', 25),
(33, 'Sony 49\'\' 4K UHD Smart TV KD-49XE7096', '6490', 'TV13.png', 'Uppgradera din tittarupplevelse med Sony 49\" 4K UHD Smart TV KD-49XE7096 och välj vad du vill titta på när som helst via applikationer som YouTube och Netflix. Upplev snabbåtkomst i 4K UHD kvalitet, s', 25),
(34, 'Sony A1 55\" 4K UHD OLED Smart TV KD55A1', '27990', 'TV14.png', '55\" 4K UHD OLED Smart-TV KD55A1 med Triluminos-skärm, X-tended Dynamic Range™ och Acoustic Surface ger dig en otrolig bildkvalitet med hjälp av 8 miljoner pixlar. TV:ns X1 Extreme processor som levere', 25),
(35, 'Sony 65\'\' 4K UHD Smart TV KD-65XE8505', '17490', 'TV15.png', 'Utforska Sony 65\'\' 4K UHD Smart TV KD-65XE8505, som ger dig en otrolig bildkvalitet och en mästerlig design som alla kommer att attraheras av. Dess slimmade profil kommer sömlöst passa in i ditt hus.', 25),
(36, 'Sony 75\'\' 4K UHD Smart TV KD-75XE9405BAE', '69990', 'TV16.png', 'Sony 75\'\' 4K UHD Smart TV KD-75XE9405BAE har en läcker tunn design, unika teknologin Slim Backlight Drive + och en kraftfull 4K Processor X1 Extreme för snabb hantering av flera funktioner och teknolo', 25),
(37, 'Sony 40\" Full HD Smart TV KDL-40WE663', '6495', 'TV17.png', 'Upptäck Sony 40\" Full HD Smart TV KDL-40WE663 med Full HD bildkvalitet, X-Reality PRO, HDR för verklighetstrogna färger och fantastisk kontrast och direktåtkomst till Youtube med bara ett knapptryck s', 25),
(38, 'Samsung Curved 65\" Q7C 4K UHD Smart TV QE65Q7', '24490', 'TV18.png', 'Samsung Curved 65\" Q7C 4K UHD Smart TV QE65Q7CAMT levererar den ljusstarkaste och skarpaste bildkvaliteten så långt. Titta på TV i SUHD eller använd TV:n för att surfa på Internet, ladda ner och strea', 25),
(39, 'Samsung Curved 75\" Q8C 4K UHD Smart TV QE75Q8', '55990', 'TV19.png', 'Samsung Curved 75\" Q8C 4K UHD Smart TV QE75Q8CAMT levererar den ljusstarkaste och skarpaste bildkvaliteten så långt. Titta på TV i SUHD eller använd TV:n för att surfa på Internet, ladda ner och strea', 25),
(40, 'Philips 65\" Ambilux 4K UHD TV 65PUS8901', '50390', 'TV20.png', 'Låt Philips Ambilux 4K UHD TV fördjupa ditt vardagsrum. Med 4K 2160p upplösning och speciell Ambilight-teknik som förlänger ut bilden på väggen tack vare projektorer.', 25);

-- --------------------------------------------------------

--
-- Table structure for table `ShoppinCart`
--

CREATE TABLE `ShoppinCart` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` varchar(45) DEFAULT NULL,
  `ProductPrice` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `UserID` int(11) NOT NULL,
  `UserEmail` varchar(45) DEFAULT NULL,
  `UserPassword` varchar(45) DEFAULT NULL,
  `UserFirstName` varchar(45) DEFAULT NULL,
  `UserLastName` varchar(45) DEFAULT NULL,
  `UserCity` varchar(45) DEFAULT NULL,
  `UserState` varchar(45) DEFAULT NULL,
  `UserType` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserID`, `UserEmail`, `UserPassword`, `UserFirstName`, `UserLastName`, `UserCity`, `UserState`, `UserType`) VALUES
(24, 'master@master.com', 'eb0a191797624dd3a48fa681d3061212', 'master', 'master', 'master', 'master', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `CommentUserID_idx` (`CommentUserID`),
  ADD KEY `CommentProductID_idx` (`CommentProductID`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `OrderUserID_idx` (`OrderUserID`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`ProductID`),
  ADD UNIQUE KEY `ProductID_UNIQUE` (`ProductID`);

--
-- Indexes for table `ShoppinCart`
--
ALTER TABLE `ShoppinCart`
  ADD PRIMARY KEY (`OrderID`,`ProductID`),
  ADD KEY `ProductID_idx` (`ProductID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserID_UNIQUE` (`UserID`),
  ADD UNIQUE KEY `UserEmail_UNIQUE` (`UserEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `CommentProductID` FOREIGN KEY (`CommentProductID`) REFERENCES `Products` (`ProductID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `CommentUserID` FOREIGN KEY (`CommentUserID`) REFERENCES `User` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `OrderUserID` FOREIGN KEY (`OrderUserID`) REFERENCES `User` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ShoppinCart`
--
ALTER TABLE `ShoppinCart`
  ADD CONSTRAINT `OrderID` FOREIGN KEY (`OrderID`) REFERENCES `Orders` (`OrderID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ProductID` FOREIGN KEY (`ProductID`) REFERENCES `Products` (`ProductID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
