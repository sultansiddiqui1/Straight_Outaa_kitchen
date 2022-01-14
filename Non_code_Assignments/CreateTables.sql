CREATE TABLE Restaurant
(
    Name VARCHAR(255) NOT NULL,
    Address VARCHAR(255) NOT NULL,
    Resturantid INTEGER NOT NULL,
    PRIMARY KEY(Resturantid)
);
CREATE TABLE Customer
(
    CustomerID INTEGER NOT NULL,
    Orders VARCHAR(255) NOT NULL,
    Address VARCHAR(255) NOT NULL,
    No_of_orders INTEGER NOT NULL,
    PRIMARY KEY (CustomerID)
);
CREATE TABLE Seats
(
    TableID INTEGER NOT NULL,
    CustomerID INTEGER,
    Available_seats INTEGER NOT NULL,
    PRIMARY KEY(TableID),
    FOREIGN KEY(CustomerID) REFERENCES Customer (CustomerID)
);
CREATE TABLE DeliveryStaff
(
    Delivery_staffID INTEGER NOT NULL,
    CustomerID INTEGER NOT NULL,
    Orders_delivered INTEGER NOT NULL,
    Delivery_loc VARCHAR(255) NOT NULL,
    Name VARCHAR(255),
    Resturantid INTEGER,
    PRIMARY KEY(Delivery_staffID),
    FOREIGN KEY (CustomerID) REFERENCES Customer (CustomerID)
);
CREATE TABLE Reviews
(
    CustomerID INTEGER UNIQUE,
    DishID INTEGER UNIQUE,
    Comment VARCHAR (255),
    Rating INTEGER,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID),
    FOREIGN KEY (DishID) REFERENCES Menu(DishID)
);
CREATE TABLE Menu
(
    DishID INTEGER,
    Food VARCHAR(255),
    Drinks VARCHAR(255),
    Todaysspecial VARCHAR(255),
    PRIMARY KEY (DishID)
);
CREATE TABLE Chef
(
    Chef_ID INTEGER UNIQUE,
    SignatureDish VARCHAR(255) NOT NULL,
    No_of_hours_worked INTEGER NOT NULL,
);