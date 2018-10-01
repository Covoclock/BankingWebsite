/*
 * insert_script.sql
 * Copyright (C) 2018 Sebastien Bah <sebastien.bah@gmail.ca>
 *
 * Distributed under terms of the MIT license.
 */

/* INSERTIONS */

-- ------------------------
-- Populate Branch table
-- ------------------------
DELETE FROM Branch;
ALTER TABLE Branch AUTO_INCREMENT = 1;

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
DELETE FROM Employee;
ALTER TABLE Employee AUTO_INCREMENT = 1;

INSERT INTO Employee(firstName, lastName, addr, start_date, salary, email, phone, branch_id)
VALUES( 'John',  'Smith', '219 Rue Berlioz', '2001-02-22', 56188.12, 'awoeif@gmail.com', '514-345-3349', 1);
INSERT INTO Employee(firstName, lastName, addr, start_date, salary, email, phone, branch_id)
VALUES( 'Michelle',  'Green', '233 Rue Gika', '2001-02-23', 58188.12, 'regtyj@gmail.com', '514-455-8988', 1);
INSERT INTO Employee(firstName, lastName, addr, start_date, salary, email, phone, branch_id)
VALUES( 'Jim',  'Jones', '111 Rue Rigo', '2003-05-20', 65444.11, 'tyjdrheg@gmail.com', '514-455-6576', 2);
INSERT INTO Employee(firstName, lastName, addr, start_date, salary, email, phone, branch_id)
VALUES( 'Kim',  'Howard', '453 Rue Tika', '2003-05-21', 76666.21, 'jyrthe@gmail.com', '514-455-3333', 2);
INSERT INTO Employee(firstName, lastName, addr, start_date, salary, email, phone, branch_id)
VALUES( 'Ann',  'Roger', '219  Trudeau', '2004-08-21', 59321.34, 'jythrt@gmail.com', '450-345-3349', 3);
INSERT INTO Employee(firstName, lastName, addr, start_date, salary, email, phone, branch_id)
VALUES( 'Tim',  'King', '233  Tilan', '2004-08-22', 61222.11, 'iuwsd@gmail.com', '450-455-8988', 3);
INSERT INTO Employee(firstName, lastName, addr, start_date, salary, email, phone, branch_id)
VALUES( 'Jack',  'Atheia', '111  frank', '2005-11-29', 63324.61, 'mnbv@gmail.com', '450-455-6576', 4);
INSERT INTO Employee(firstName, lastName, addr, start_date, salary, email, phone, branch_id)
VALUES( 'Kim',  'Stefen', '453  Demo', '2005-11-30', 63333.22, 'zxcvds@gmail.com', '450-455-3333', 4);

/* Cote Des Neiges */
INSERT INTO Employee(firstName, lastName, addr, start_date, salary, email, phone, branch_id)
VALUES( 'Kilian',  'karl', '453  Demo', '2003-11-29', 63333.22, 'zsadas@gmail.com', '450-555-5533', 5);
INSERT INTO Employee(firstName, lastName, addr, start_date, salary, email, phone, branch_id)
VALUES( 'Karlito',  'kilimanjaro', '453  Demo', '2003-11-29', 63333.22, 'as3ds@gmail.com', '450-555-3355', 5);

/* Set managers and president */
UPDATE Branch SET manager_id = 1 WHERE branch_id = 1; -- President
UPDATE Branch SET manager_id = 3 WHERE branch_id = 2; 
UPDATE Branch SET manager_id = 5 WHERE branch_id = 3; 
UPDATE Branch SET manager_id = 7 WHERE branch_id = 4; 
UPDATE Branch SET manager_id = 9 WHERE branch_id = 5; 


-- ------------------------
-- Populate Client table
-- ------------------------
DELETE FROM Client;
ALTER TABLE Client AUTO_INCREMENT = 1;

INSERT INTO Client(firstName, lastName, addr, dob, joining_date, email, phone,  branch_id)
VALUES('Ricky', 'Martin', '342 rue Cote Des Neiges', '1980-02-22', '2003-1-12', 'bnos@gmail.com', '514-222-3456', 2);
INSERT INTO Client( firstName, lastName, addr, dob, joining_date, email, phone,  branch_id)
VALUES('Roberto', 'Yuan', '111 rue Young', '1990-03-11', '2003-12-24', 'trdhge@gmail.com', '514-222-6544', 2);
INSERT INTO Client( firstName, lastName, addr, dob, joining_date, email, phone,  branch_id)
VALUES('Tina', 'Ita', '675 rue William', '1983-02-22', '2004-12-26', 'bnos@gmail.com', '450-222-9877', 3);
INSERT INTO Client( firstName, lastName, addr, dob, joining_date, email, phone,  branch_id)
VALUES('Bob', 'Bush', '456 rue Young', '1995-03-11', '2005-12-28', 'trdhge@gmail.com', '450-222-5675', 4);

/* Cote Des Neiges */
INSERT INTO Client( firstName, lastName, addr, dob, joining_date, email, phone,  branch_id)
VALUES('Tina', 'Turner', '675 rue Ontario', '1983-02-22', '2003-10-16', 'bgsdos@gmail.com', '450-222-9877', 5);
INSERT INTO Client( firstName, lastName, addr, dob, joining_date, email, phone,  branch_id)
VALUES('billy', 'Bush', '456 rue Sherbrooke', '1995-03-11', '2003-12-22', 'asdae@gmail.com', '450-222-5675', 5);

-- ------------------------
-- Populate Account table
-- ------------------------
DELETE FROM Account;
ALTER TABLE Account AUTO_INCREMENT = 1;

INSERT INTO Account(client_id, account_type, account_option, balance, credit_limit, interest_rate)
VALUES(1, 'saving', 'high interest', 8000.32,  9000.00, 0.02);
INSERT INTO Account(client_id, account_type, account_option, balance, credit_limit, interest_rate)
VALUES(1, 'chequing', 'regular', 5432.32,  20000.00, 0.03);
INSERT INTO Account(client_id, account_type, account_option, balance, credit_limit, interest_rate)
VALUES(2, 'saving', 'enhanced interest', 65432.11,  30000.00, 0.03);
INSERT INTO Account(client_id, account_type, account_option, balance, credit_limit, interest_rate)
VALUES(2, 'chequing', 'primium', 7655.23,  25000.00, 0.02);
INSERT INTO Account(client_id, account_type, account_option, balance, credit_limit, interest_rate)
VALUES(3, 'saving', 'high interest', 20065.32,  25000.00, 0.04);
INSERT INTO Account(client_id, account_type, account_option, balance, credit_limit, interest_rate)
VALUES(3, 'chequing', 'regular', 45333.32,  30000.00, 0.04);
INSERT INTO Account(client_id, account_type, account_option, balance, credit_limit, interest_rate)
VALUES(4, 'saving', 'enhanced interest', 1000000.00,  50000.00, 0.05);
INSERT INTO Account(client_id, account_type, account_option, balance, credit_limit, interest_rate)
VALUES(4, 'chequing', 'primium', 76554.23,  40000.00, 0.05);

/* Cote Des Neiges */
INSERT INTO Account(client_id, account_type, account_option, balance, credit_limit, interest_rate)
VALUES(5, 'saving', 'enhanced interest', 435440.11,  50000.00, 0.08);
INSERT INTO Account(client_id, account_type, account_option, balance, credit_limit, interest_rate)
VALUES(6, 'chequing', 'regular', 7655.23,  40000.00, 0.05);

-- ------------------------
-- Populate Services table
-- ------------------------
DELETE FROM Services;
ALTER TABLE Services AUTO_INCREMENT = 1;

INSERT INTO Services(service_name, manager_id)
VALUES('saving', 2);
INSERT INTO Services(service_name, manager_id)
VALUES('chequing', 4);
INSERT INTO Services(service_name, manager_id)
VALUES('line of credit', 6);
INSERT INTO Services(service_name, manager_id)
VALUES('loan', 8);
