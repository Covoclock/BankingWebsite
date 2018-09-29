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


INSERT INTO Branch(province, city, street, phone, fax, opening_date, manager_id, isHeadOffice)
VALUES('Quebec', 'Montreal', 'William', '514-365-2589', '514-258-2656', '2001-02-22', 10031, 1);
INSERT INTO Branch(branch_id, province, city, street, phone, fax, opening_date, manager_id, isHeadOffice)
VALUES('Quebec', 'Montreal', 'Berlioz', '514-365-2345', '514-258-8765', '2003-05-20', 20031, 0);
INSERT INTO Branch(branch_id, province, city, street, phone, fax, opening_date, manager_id, isHeadOffice)
VALUES('Ontario', 'Toronto', 'Canadian', '450-365-7658', '450-453-8899', '2004-08-21', 40031, 0);
INSERT INTO Branch(branch_id, province, city, street, phone, fax, opening_date, manager_id, isHeadOffice)
VALUES('Ontario', 'Toronto', 'Ford', '450-365-3433', '450-453-6677', '2005-11-29', 50031, 0);


-- ------------------------
-- Populate Employee table
-- ------------------------

INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE( 'John',  'Smith', '219 Rue Berlioz', '2001-02-22', 56188.12, 'awoeif@gmail.com', '514-345-3349', 1,10);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE( 'Michelle',  'Green', '233 Rue Gika', '2001-02-22', 58188.12, 'regtyj@gmail.com', '514-455-8988', 1,11);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE( 'Jim',  'Jones', '111 Rue Rigo', '2003-05-20', 65444.11, 'tyjdrheg@gmail.com', '514-455-6576', 2,10);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE( 'Kim',  'Howard', '453 Rue Tika', '2003-05-20', 76666.21, 'jyrthe@gmail.com', '514-455-3333', 2,11);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE( 'Ann',  'Roger', '219  Trudeau', '2004-08-21', 59321.34, 'jythrt@gmail.com', '450-345-3349', 3,10);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE( 'Tim',  'King', '233  Tilan', '2004-08-21', 61222.11, 'iuwsd@gmail.com', '450-455-8988', 3,11);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE( 'Jack',  'Atheia', '111  frank', '2005-11-29', 63324.61, 'mnbv@gmail.com', '450-455-6576', 4,10);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE( 'Kim',  'Stefen', '453  Demo', '2005-11-29', 63333.22, 'zxcvds@gmail.com', '450-455-3333', 4,11);


-- ------------------------
-- Populate Client table
-- ------------------------


INSERT INTO Client(firstName, lastName, addr, dob, joining_date, email, phone,  branch_id)
VALUE('Ricky', 'Martin', '342 rue berlioz', '1980-02-22', '2003-1-12', 'bnos@gmail.com', '514-222-3456', 1);
INSERT INTO Client(client_id, firstName, lastName, addr, dob, joining_date, email, phone,  branch_id)
VALUE('Mei', 'Yuan', '111 rue Young', '1990-03-11', '2003-12-24', 'trdhge@gmail.com', '514-222-6544', 2);
INSERT INTO Client(client_id, firstName, lastName, addr, dob, joining_date, email, phone,  branch_id)
VALUE('Tina', 'Ita', '675 rue William', '1983-02-22', '2004-12-26', 'bnos@gmail.com', '450-222-9877', 3);
INSERT INTO Client(client_id, firstName, lastName, addr, dob, joining_date, email, phone,  branch_id)
VALUE('Bob', 'Bush', '456 rue Young', '1995-03-11', '2005-12-28', 'trdhge@gmail.com', '450-222-5675', 4);


-- ------------------------
-- Populate Account table
-- ------------------------

INSERT INTO Account(client_id, account_type, account_option, balance, line_credit_limit)
VALUE(1, 'saving', 'high interest', 10000.32,  100000.00);
INSERT INTO Account(client_id, account_type, account_option, balance, line_credit_limit)
VALUE(1, 'chequing', 'regular', 54323.32,  20000.00);
INSERT INTO Account(client_id, account_type, account_option, balance, line_credit_limit)
VALUE(2, 'saving', 'enhanced interest', 65432.11,  30000.00);
INSERT INTO Account(client_id, account_type, account_option, balance, line_credit_limit)
VALUE(2, 'chequing', 'primium', 76554.23,  26000.00);
INSERT INTO Account(client_id, account_type, account_option, balance, line_credit_limit)
VALUE(3, 'saving', 'high interest', 20065.32,  26000.00);
INSERT INTO Account(client_id, account_type, account_option, balance, line_credit_limit)
VALUE(3, 'chequing', 'regular', 45333.32,  30000.00);
INSERT INTO Account(client_id, account_type, account_option, balance, line_credit_limit)
VALUE(4, 'saving', 'enhanced interest', 43544.11,  50000.00);
INSERT INTO Account(client_id, account_type, account_option, balance, line_credit_limit)
VALUE(4, 'chequing', 'primium', 76554.23,  40000.00);

-- ------------------------
-- Populate Services table
-- ------------------------

INSERT INTO Services(service_name, manager_id)
VALUE('saving', 2);
INSERT INTO Services(service_name, manager_id)
VALUE('chequing', 4);
INSERT INTO Services(service_name, manager_id)
VALUE('line of credit', 6);
INSERT INTO Services(service_name, manager_id)
VALUE('loan', 8);

