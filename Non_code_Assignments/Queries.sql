SELECT
  *
FROM
  DeliveryStaff
WHERE
  Orders_delivered > 10;
  
  
SELECT
  *
FROM
  Chef
WHERE
  No_of_hrs_worked > 70;
  
  
SELECT
  *
FROM
  Chef
WHERE
  SignatureDish = 'WaiWai Noodles';
  
SELECT
  *
FROM
  Customer
WHERE
  No_of_orders > 5;
  
  
SELECT
  *
From
  Reviews
WHERE
  Rating > 4;
  
  
SELECT
  *
From
  Reviews
WHERE
  Rating < 3;
  
  
SELECT
  *
From
  DeliveryStaff
WHERE
  CustomerID = '1';
  
  
SELECT
  *
FROM
  Seats
WHERE
  Available_seats > 8;
  
  
SELECT
  *
FROM
  Seats
WHERE
  Years_worked > 5;
  
  
SELECT
  *
FROM
  Chef
WHERE
  Years_worked =(
    SELECT
      MAX(Years_worked)
    FROM
      Chef
  );
  
  
Select
  COUNT(CustomerID),
  Address
FROM
  Customer
Group By
  Address;
  
  
SELECT
  Chef.Chef_ID,
  DeliveryStaff.Delivery_staffID
FROM
  Chef
  INNER JOIN DeliveryStaff ON Chef.Resturantid = DeliveryStaff.Resturantid;
  
  
SELECT
  Menu.Food,
  Reviews.Comment
FROM
  Menu
  INNER JOIN Reviews ON Menu.DishID = Reviews.DishID;
  
  
SELECT
  Customer.Orders,
  DeliveryStaff.Delivery_loc
FROM
  DeliveryStaff
  INNER JOIN Customer ON Customer.CustomerID = DeliveryStaff.CustomerID;