/*
 * insert_script.sql
 * Copyright (C) 2018 Sebastien Bah <sebastien.bah@gmail.ca>
 *
 * Distributed under terms of the MIT license.
 */
SET FOREIGN_KEY_CHECKS=0;
/* INSERTIONS */

-- ------------------------

-- Populate Branch table

-- ------------------------
TRUNCATE TABLE Branch;

INSERT INTO Branch(province, city, street, phone, fax, opening_date, isHeadOffice)

VALUES('Quebec', 'Montreal', 'William', '514-365-2589', '514-258-2656', '2001-02-22',  1);

INSERT INTO Branch( province, city, street, phone, fax, opening_date, isHeadOffice)

VALUES('Quebec', 'Montreal', 'Berlioz', '514-365-2345', '514-258-8765', '2003-05-20',  0);

INSERT INTO Branch( province, city, street, phone, fax, opening_date, isHeadOffice)

VALUES('Ontario', 'Toronto', 'Canadian', '450-365-7658', '450-453-8899', '2004-08-21', 0);

INSERT INTO Branch( province, city, street, phone, fax, opening_date, isHeadOffice)

VALUES('Ontario', 'Toronto', 'Ford', '450-365-3433', '450-453-6677', '2005-11-29',  0);



/* Cote Des Neiges */

INSERT INTO Branch( province, city, street, phone, fax, opening_date, isHeadOffice)

VALUES('Quebec', 'Montreal', 'Cote Des Neiges', '514-555-1515', '514-555-5151', '2002-03-10',  0);


-- ------------------------

-- Populate Employee table

-- ------------------------
TRUNCATE TABLE Employee;

INSERT INTO Employee(firstName, lastName, addr, start_date, wage, email, phone, branch_id)

VALUES( 'John',  'Smith', '219 Rue Berlioz', '2001-02-22', 20.12, 'awoeif@gmail.com', '514-345-3349', 1);

INSERT INTO Employee(firstName, lastName, addr, start_date, wage, email, phone, branch_id)

VALUES( 'Michelle',  'Green', '233 Rue Gika', '2001-02-23', 30.12, 'regtyj@gmail.com', '514-455-8988', 1);

INSERT INTO Employee(firstName, lastName, addr, start_date, wage, email, phone, branch_id)

VALUES( 'Jim',  'Jones', '111 Rue Rigo', '2003-05-20', 25.11, 'tyjdrheg@gmail.com', '514-455-6576', 2);

INSERT INTO Employee(firstName, lastName, addr, start_date, wage, email, phone, branch_id)

VALUES( 'Kim',  'Howard', '453 Rue Tika', '2003-05-21', 35.21, 'jyrthe@gmail.com', '514-455-3333', 2);

INSERT INTO Employee(firstName, lastName, addr, start_date, wage, email, phone, branch_id)

VALUES( 'Ann',  'Roger', '219  Trudeau', '2004-08-21', 14.34, 'jythrt@gmail.com', '450-345-3349', 3);

INSERT INTO Employee(firstName, lastName, addr, start_date, wage, email, phone, branch_id)

VALUES( 'Tim',  'King', '233  Tilan', '2004-08-22', 37.11, 'iuwsd@gmail.com', '450-455-8988', 3);

INSERT INTO Employee(firstName, lastName, addr, start_date, wage, email, phone, branch_id)

VALUES( 'Jack',  'Atheia', '111  frank', '2005-11-29', 90.61, 'mnbv@gmail.com', '450-455-6576', 4);

INSERT INTO Employee(firstName, lastName, addr, start_date, wage, email, phone, branch_id)

VALUES( 'Kim',  'Stefen', '453  Demo', '2005-11-30', 23.22, 'zxcvds@gmail.com', '450-455-3333', 4);



/* Cote Des Neiges */

INSERT INTO Employee(firstName, lastName, addr, start_date, wage, email, phone, branch_id)

VALUES( 'Kilian',  'karl', '453  Demo', '2003-11-29', 47.22, 'zsadas@gmail.com', '450-555-5533', 5);

INSERT INTO Employee(firstName, lastName, addr, start_date, wage, email, phone, branch_id)

VALUES( 'Karlito',  'kilimanjaro', '453  Demo', '2003-11-29', 15.22, 'as3ds@gmail.com', '450-555-3355', 5);


/* Set managers and president */

UPDATE Branch SET manager_id = 1 WHERE branch_id = 1; -- President

UPDATE Branch SET manager_id = 3 WHERE branch_id = 2;

UPDATE Branch SET manager_id = 5 WHERE branch_id = 3;

UPDATE Branch SET manager_id = 7 WHERE branch_id = 4;

UPDATE Branch SET manager_id = 9 WHERE branch_id = 5;





-- ------------------------

-- Populate Client table

-- ------------------------
TRUNCATE TABLE Client;


INSERT INTO Client(firstName, lastName, city, province, dob, join_date, standing, email, phone, category, branch_id)

VALUES('Ricky', 'Martin', 'Montreal','Quebec', '1980-02-22', '2003-1-12',0, 'bno@gmail.com', '514-222-3456', 'regular',2);

INSERT INTO Client(firstName, lastName, city, province, dob, join_date, standing, email, phone, category, branch_id)

VALUES('Roberto', 'Yuan', 'Toronto', 'Ontario', '1990-03-11', '2003-12-24', '0', 'trdhasge@gmail.com', '514-222-6544', 'student', 2);

INSERT INTO Client(firstName, lastName, city, province, dob, join_date, standing, email, phone, category, branch_id)

VALUES('Tina', 'Ita', 'Montreal', 'Quebec', '1983-02-22', '2004-12-26', '1','bnosas@gmail.com', '450-222-9877', 'senior', 3);

INSERT INTO Client(firstName, lastName, city, province, dob, join_date, standing, email, phone, category, branch_id)

VALUES('Bob', 'Bush', 'Toronto', 'Ontario', '1995-03-11', '2005-12-28', '1','trasdhge@gmail.com', '450-222-5995', 'regular',4);



/* Cote Des Neiges */

INSERT INTO Client(firstName, lastName, city, province, dob, join_date, standing, email, phone, category, branch_id)

VALUES('Tina', 'Turner', 'Montreal', 'Quebec', '1983-02-22', '2003-10-16', '1','bgsdosman@gmail.com', '450-222-9337', 'student', 5);

INSERT INTO Client(firstName, lastName, city, province, dob, join_date, standing, email, phone, category, branch_id)

VALUES('billy', 'Bush', 'Montreal', 'Quebec', '1995-03-11', '2003-12-22', '0', 'asaaadae@gmail.com', '450-222-5675', 'regular',5);


/*BRANCH clients */

INSERT INTO Client(firstName, lastName, city, province, dob, join_date, standing, email, phone, category, branch_id)

VALUES('1', 'Branch', 'Montreal', 'Quebec', '1983-02-22', '2003-10-16', '1','none', '450-222-9337', 'Branch', 1);

INSERT INTO Client(firstName, lastName, city, province, dob, join_date, standing, email, phone, category, branch_id)

VALUES('2', 'Branch', 'Montreal', 'Quebec', '1995-03-11', '2003-12-22', '0', 'none', '450-222-5675', 'Branch',2);

INSERT INTO Client(firstName, lastName, city, province, dob, join_date, standing, email, phone, category, branch_id)

VALUES('3', 'Branch', 'Toronto', 'Ontario', '1983-02-22', '2003-10-16', '1','none', '450-222-9337', 'Branch', 3);

INSERT INTO Client(firstName, lastName, city, province, dob, join_date, standing, email, phone, category, branch_id)

VALUES('4', 'Branch', 'Toronto', 'Ontario', '1995-03-11', '2003-12-22', '0', 'none', '450-222-5675', 'Branch',4);

INSERT INTO Client(firstName, lastName, city, province, dob, join_date, standing, email, phone, category, branch_id)

VALUES('5', 'Branch', 'Montreal', 'Quebec', '1995-03-11', '2003-12-22', '0', 'none', '450-222-5675', 'Branch',5);

/*Branch 1 client */
INSERT INTO Client(firstName, lastName, city, province, dob, join_date, standing, email, phone, category, branch_id)

VALUES('Serj', 'Tankian', 'Montreal', 'Quebec', '1995-03-11', '2003-12-22', '1', 'asaaadae@gmail.com', '450-222-5675', 'regular', 1);



-- ------------------------

-- Populate ChargePlan Table

-- ------------------------
TRUNCATE TABLE ChargePlan;

INSERT INTO ChargePlan(chargePlan_id, option_name, draw_limit, charge_value)
VALUE (0, 'PERFORMANCE', 20, 10);
INSERT INTO ChargePlan(chargePlan_id, option_name, draw_limit, charge_value)
VALUE (1, 'PREMIUM', 200, 50);
INSERT INTO ChargePlan(chargePlan_id, option_name, draw_limit, charge_value)
VALUE (2, 'PLUS', 50, 20);
INSERT INTO ChargePlan(chargePlan_id, option_name, draw_limit, charge_value)
VALUE (3, 'AIRMILES', 40, 25);
INSERT INTO ChargePlan(chargePlan_id, option_name, draw_limit, charge_value)
VALUE (4, 'PRACTICAL', 5, 0);


-- ------------------------

-- Populate Account table

-- ------------------------
TRUNCATE TABLE Account;

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)

VALUES(1, 'saving', 0, 8000.32,  9000.00, 0.02, 'personal', 10);

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)

VALUES(1, 'chequing', 1, 5432.32,  20000.00, 0.03, 'business', 8);

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)

VALUES(2, 'saving', 2, 65432.11,  30000.00, 0.03, 'corporate', 7);

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)
VALUES(2, 'chequing', 3, 7655.23,  25000.00, 0.02, 'personal', 6);

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)
VALUES(3, 'saving', 4, 20065.32,  25000.00, 0.04, 'corporate', 5);

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)
VALUES(3, 'chequing', 1, 45333.32,  30000.00, 0.04, 'personal', 4);

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)
VALUES(4, 'saving', 2, 1000000.00,  50000.00, 0.05, 'business', 3);

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)
VALUES(4, 'chequing', 3, 76554.23,  40000.00, 0.05, 'business', 2);



/* Cote Des Neiges */

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)
VALUES(5, 'saving', 4, 435440.11,  50000.00, 0.08, 'personal', 4);

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)
VALUES(6, 'chequing', 3, 7655.23,  40000.00, 0.05, 'business', 5);

/*Branch account to receive collected fees */

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)
VALUES(7, 'Branch', 4, 0, 0, 0, 'Branch', 100000);

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)
VALUES(8, 'Branch', 4, 0, 0, 0, 'Branch', 100000);

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)
VALUES(9, 'Branch', 4, 0, 0, 0, 'Branch', 100000);

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)
VALUES(10, 'Branch', 4, 0, 0, 0, 'Branch', 100000);

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)
VALUES(11, 'Branch', 4, 0, 0, 0, 'Branch', 100000);


/* */
INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)
VALUES(13, 'saving', 4, 435440.11,  50000.00, 0.08, 'personal', 4);

INSERT INTO Account(client_id, account_type, chargePlan_id, balance, credit_limit, interest_rate, lvl, transactionLeft)
VALUES(13, 'credit', 3, 7655.23,  40000.00, 5.00, 'personal', 5);


-- ------------------------

-- Populate Services table

-- ------------------------

TRUNCATE TABLE Services;

ALTER TABLE Services AUTO_INCREMENT = 1;

select * from Services;

INSERT INTO Services(service_name, manager_id)

VALUES('saving', 2);

INSERT INTO Services(service_name, manager_id)

VALUES('chequing', 4);

INSERT INTO Services(service_name, manager_id)

VALUES('line of credit', 6);

INSERT INTO Services(service_name, manager_id)

VALUES('loan', 8);


-- ------------------------
-- Populate Transactions table
-- ------------------------
TRUNCATE TABLE Transactions;


INSERT INTO Transactions(account1_id, account2_id, amount, dt)
VALUE(1,2,100.00,now());
INSERT INTO Transactions(account1_id, account2_id, amount, dt)
VALUE(3,2,300.00,now());
INSERT INTO Transactions(account1_id, account2_id, amount, dt)
VALUE(4,2,200.00,now());
INSERT INTO Transactions(account1_id, account2_id, amount, dt)
VALUE(6,5,400.00,now());
INSERT INTO Transactions(account1_id, account2_id, amount, dt)
VALUE(7,1,500.00,now());
INSERT INTO Transactions(account1_id, account2_id, amount, dt)
VALUE(1,3,600.00,now());
INSERT INTO Transactions(account1_id, account2_id, amount, dt)
VALUE(4,2,700.00,now());


-- ------------------------
-- Populate Bills table
-- ------------------------
TRUNCATE TABLE Bills; 

INSERT INTO Bills(amount, account1_id, account2_id, recurring)
VALUE (300.00, 3,4,0);
INSERT INTO Bills(amount, account1_id, account2_id, recurring)
VALUE (100.00, 5,4,1);
INSERT INTO Bills(amount, account1_id, account2_id, recurring)
VALUE (257.00, 1,4,1);
INSERT INTO Bills(amount, account1_id, account2_id, recurring)
VALUE (188.00, 3,6,0);
INSERT INTO Bills(amount, account1_id, account2_id, recurring)
VALUE (233.00, 6,5,0);
INSERT INTO Bills(amount, account1_id, account2_id, recurring)
VALUE (67.00, 2,8,1);



-- ------------------------
-- Populate EmployeeLogin table
-- ------------------------
TRUNCATE TABLE EmployeeLogin;

INSERT INTO EmployeeLogin(employee_id, psw)
VALUE (1,'bank');
INSERT INTO EmployeeLogin(employee_id, psw)
VALUE (2,'bank');
INSERT INTO EmployeeLogin(employee_id, psw)
VALUE (3,'bank');
INSERT INTO EmployeeLogin(employee_id, psw)
VALUE (4,'bank');
INSERT INTO EmployeeLogin(employee_id, psw)
VALUE (5,'bank');
INSERT INTO EmployeeLogin(employee_id, psw)
VALUE (6,'bank');
INSERT INTO EmployeeLogin(employee_id, psw)
VALUE (7,'bank');
INSERT INTO EmployeeLogin(employee_id, psw)
VALUE (8,'bank');
INSERT INTO EmployeeLogin(employee_id, psw)
VALUE (9,'bank');
INSERT INTO EmployeeLogin(employee_id, psw)
VALUE (10,'bank');



-- ------------------------

-- Populate ClientLogin table

-- ------------------------
TRUNCATE TABLE ClientLogin;

INSERT INTO ClientLogin(client_id, psw) VALUE (1, "p1");
INSERT INTO ClientLogin(client_id, psw) VALUE (2, "p2");
INSERT INTO ClientLogin(client_id, psw) VALUE (3, "p3");
INSERT INTO ClientLogin(client_id, psw) VALUE (4, "p4");
INSERT INTO ClientLogin(client_id, psw) VALUE (5, "p5");
INSERT INTO ClientLogin(client_id, psw) VALUE (6, "p6");


-- ------------------------

-- Populate Schedule table

-- ------------------------
TRUNCATE TABLE Schedule;

INSERT INTO Schedule(employee_id, work_date, hour_begin, hour_end, isHoliday)
VALUE (1,'2018-06-21', 9, 17, 1);
INSERT INTO Schedule(employee_id, work_date, hour_begin, hour_end, isHoliday)
VALUE (2,'2018-01-23', 9, 17, 1);
INSERT INTO Schedule(employee_id, work_date, hour_begin, hour_end, isHoliday)
VALUE (3,'2018-02-18', 9, 17, 1);
INSERT INTO Schedule(employee_id, work_date, hour_begin, hour_end, isHoliday)
VALUE (4,'2018-03-15', 9, 17, 1);
INSERT INTO Schedule(employee_id, work_date, hour_begin, hour_end, isHoliday)
VALUE (5,'2018-04-21', 9, 17, 1);
INSERT INTO Schedule(employee_id, work_date, hour_begin, hour_end, isHoliday)
VALUE (6,'2018-05-30', 9, 17, 1);



SET FOREIGN_KEY_CHECKS=1;
