DROP Table if exists cardType;
DROP TABLE IF EXISTS customers;

CREATE TABLE customers (
    id INT NOT NULL AUTO_INCREMENT,
    fname VARCHAR(40),
    lname VARCHAR(40),
    address VARCHAR(100),
    stateID VARCHAR(2),
    zip INT,
    email VARCHAR(100) NOT NULL,
    hashedpass VARCHAR(255),
    cardName VARCHAR(100),
    cardType INT,
    ccNumber VARCHAR(16),
    ccExDate VARCHAR(5),
    ccCVV VARCHAR(3),
    PRIMARY KEY (id)
);

create table cardType(
    id INT NOT NULL AUTO_INCREMENT,
    CardName VARCHAR(20) NOT NULL,
    PRIMARY KEY(id)
);

Insert into cardType(CardName)Values('Visa');
Insert into cardType(CardName)Values('Mastercard');
Insert into cardType(CardName)Values('American Express');
Insert into cardType(CardName)Values('Discover');
