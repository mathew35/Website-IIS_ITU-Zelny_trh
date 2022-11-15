DROP TABLE IF EXISTS ORDERS;

DROP TABLE IF EXISTS CART_CROP;

DROP TABLE IF EXISTS SHOPPING_CART;

DROP TABLE IF EXISTS HARVEST_CROP;

DROP TABLE IF EXISTS RATING;

DROP TABLE IF EXISTS SPECIFIC_CROP;

DROP TABLE IF EXISTS CROP;

DROP TABLE IF EXISTS CATEGORY;

DROP TABLE IF EXISTS RATING_OF_FARMER;

DROP TABLE IF EXISTS HARVEST_EVENT_ATTENDANTS;

DROP TABLE IF EXISTS HARVEST_EVENT;

DROP TABLE IF EXISTS FARMERS;

DROP TABLE IF EXISTS REGISTERED;

DROP TABLE IF EXISTS ACCOUNTS;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET TIME_ZONE = "+02:00";

CREATE TABLE ACCOUNTS (
    ID INT(11) NOT NULL PRIMARY KEY,
    LOGIN VARCHAR(64) NOT NULL,
    PASSWORD VARCHAR(128) NOT NULL
);

ALTER TABLE ACCOUNTS ADD UNIQUE KEY LOGIN (LOGIN);

ALTER TABLE ACCOUNTS MODIFY ID INT(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE REGISTERED(
    LOGIN VARCHAR(64) NOT NULL PRIMARY KEY,
    FULLNAME VARCHAR(64) NOT NULL,
    EMAIL VARCHAR(64) NOT NULL,
    FOREIGN KEY (LOGIN) REFERENCES ACCOUNTS (LOGIN)
);

CREATE TABLE FARMERS (
    LOGIN VARCHAR(64) NOT NULL PRIMARY KEY,
    ADDRESS VARCHAR(64) NOT NULL,
    ICO INT(20) NOT NULL,
    PHONE INT(12) NOT NULL,
    IBAN VARCHAR(32) NOT NULL,
    FOREIGN KEY (LOGIN) REFERENCES ACCOUNTS(LOGIN)
);

-- CREATE TABLE CUSTOMER(
-- );

CREATE TABLE HARVEST_EVENT(
    EVENTID INT(64) NOT NULL PRIMARY KEY,
    DATE_FROM DATE NOT NULL,
    DATE_TO DATE NOT NULL,
    PLACE VARCHAR(64) NOT NULL,
    DESCRIPTION VARCHAR(300) NOT NULL,
    POSTEDBY VARCHAR(64) NOT NULL,
    FOREIGN KEY (POSTEDBY) REFERENCES FARMERS(LOGIN)
);

CREATE TABLE HARVEST_EVENT_ATTENDANTS(
    EVENTID INT(64) NOT NULL,
    LOGIN VARCHAR(64) NOT NULL,
    FOREIGN KEY (EVENTID) REFERENCES HARVEST_EVENT(EVENTID),
    FOREIGN KEY (LOGIN) REFERENCES REGISTERED(LOGIN),
    PRIMARY KEY (EVENTID, LOGIN)
);

CREATE TABLE RATING_OF_FARMER(
    RATINGID INT(64) NOT NULL,
    AVG_RATING FLOAT(3) NOT NULL,
    FARMER VARCHAR(64) NOT NULL PRIMARY KEY,
    FOREIGN KEY (FARMER) REFERENCES FARMERS(LOGIN)
);

CREATE TABLE CATEGORY(
    CATEGORY VARCHAR(64) PRIMARY KEY
);

CREATE TABLE CROP(
    CROPTYPE VARCHAR(64) PRIMARY KEY,
    CATEGORY VARCHAR(64) NOT NULL,
    FOREIGN KEY (CATEGORY) REFERENCES CATEGORY(CATEGORY)
);

CREATE TABLE SPECIFIC_CROP(
    CROPID INT(64) NOT NULL PRIMARY KEY,
    CROP VARCHAR(64) NOT NULL,
    CATEGORY VARCHAR(64) NOT NULL,
    CROP_NAME VARCHAR(64) NOT NULL,
    AMOUNT INT(64) DEFAULT 0,
    PRICE FLOAT(10) DEFAULT 0,
    PER_UNIT INT(64) DEFAULT 0,
 -- photo path??? default null,
    DESCRIPTION VARCHAR(128),
    FOREIGN KEY (CATEGORY) REFERENCES CROP(CATEGORY),
    FOREIGN KEY (CROP) REFERENCES CROP(CROPTYPE)
);

CREATE TABLE RATING(
    RATINGID INT(64) NOT NULL,
    STARS FLOAT(3) NOT NULL,
    DESCRIPTION VARCHAR(100),
    REGISTERED VARCHAR(64) NOT NULL,
    FARMER VARCHAR(64) NOT NULL,
    CROP INT(64) NOT NULL,
    FOREIGN KEY (REGISTERED) REFERENCES REGISTERED(LOGIN),
    FOREIGN KEY (FARMER) REFERENCES FARMERS(LOGIN),
    FOREIGN KEY (CROP) REFERENCES SPECIFIC_CROP(CROPID)
);

CREATE TABLE HARVEST_CROP(
    CROPID INT(64) NOT NULL,
    EVENTID INT(64) NOT NULL,
    FOREIGN KEY (CROPID) REFERENCES SPECIFIC_CROP(CROPID),
    FOREIGN KEY (EVENTID) REFERENCES HARVEST_EVENT(EVENTID),
    PRIMARY KEY (EVENTID, CROPID)
);

CREATE TABLE SHOPPING_CART(
    CARTID INT(64) NOT NULL PRIMARY KEY,
    CART_VALUE INT(64),
    ITEM_COUNT INT(64) DEFAULT 0
);

CREATE TABLE CART_CROP(
    CARTID INT(64) NOT NULL,
    CROPID INT(64) NOT NULL,
    AMOUNT INT(64) NOT NULL,
    FOREIGN KEY (CARTID) REFERENCES SHOPPING_CART(CARTID),
    FOREIGN KEY (CROPID) REFERENCES SPECIFIC_CROP(CROPID),
    PRIMARY KEY (CARTID, CROPID)
);

CREATE TABLE ORDERS(
    ORDERID INT(64) NOT NULL PRIMARY KEY,
    CARTID INT(64) NOT NULL,
    DUE_DATE DATE NOT NULL,
    ORIGIN_DATE DATE NOT NULL,
    FARMER VARCHAR(64) NOT NULL,
    FOREIGN KEY (FARMER) REFERENCES FARMERS(LOGIN),
    FOREIGN KEY (CARTID) REFERENCES SHOPPING_CART(CARTID)
 -- ?? ako prepojit s crop ?
);
