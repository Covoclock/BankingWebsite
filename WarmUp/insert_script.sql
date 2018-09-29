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

INSERT INTO Branch(branch_id, province, city, street, phone, fax, opening_date, manager_id, isHeadOffice)
VALUES(100, 'Quebec', 'Montreal', 'William', '514-365-2589', '514-258-2656', '2001-02-22', 10031, 1);
INSERT INTO Branch(branch_id, province, city, street, phone, fax, opening_date, manager_id, isHeadOffice)
VALUES(101, 'Quebec', 'Montreal', 'Berlioz', '514-365-2345', '514-258-8765', '2003-05-20', 20031, 0);
INSERT INTO Branch(branch_id, province, city, street, phone, fax, opening_date, manager_id, isHeadOffice)
VALUES(201, 'Ontario', 'Toronto', 'Canadian', '450-365-7658', '450-453-8899', '2004-08-21', 40031, 0);
INSERT INTO Branch(branch_id, province, city, street, phone, fax, opening_date, manager_id, isHeadOffice)
VALUES(202, 'Ontario', 'Toronto', 'Ford', '450-365-3433', '450-453-6677', '2005-11-29', 50031, 0);


-- ------------------------
-- Populate Employee table
-- ------------------------

INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUES(1001, 'John',  'Smith', '219 Rue Berlioz', '2001-02-22', 56188.12, 'awoeif@gmail.com', '514-345-3349', 100,10);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUES(1002, 'Michelle',  'Green', '233 Rue Gika', '2001-02-22', 58188.12, 'regtyj@gmail.com', '514-455-8988', 100,11);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUES(1011, 'Jim',  'Jones', '111 Rue Rigo', '2003-05-20', 65444.11, 'tyjdrheg@gmail.com', '514-455-6576', 101,10);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUES(1012, 'Kim',  'Howard', '453 Rue Tika', '2003-05-20', 76666.21, 'jyrthe@gmail.com', '514-455-3333', 101,11);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUES(2011, 'Ann',  'Roger', '219  Trudeau', '2004-08-21', 59321.34, 'jythrt@gmail.com', '450-345-3349', 201,10);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUES(2012, 'Tim',  'King', '233  Tilan', '2004-08-21', 61222.11, 'iuwsd@gmail.com', '450-455-8988', 201,11);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUES(2021, 'Jack',  'Atheia', '111  frank', '2005-11-29', 63324.61, 'mnbv@gmail.com', '450-455-6576', 202,10);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUES(2022, 'Kim',  'Stefen', '453  Demo', '2005-11-29', 63333.22, 'zxcvds@gmail.com', '450-455-3333', 202,11);
-- vim:et

-- ------------------------
-- Populate Client table
-- ------------------------

INSERT INTO Client(client_id, firstName, lastName, addr, dob, joining_date, email, phone,  branch_id)
VALUE(100001,'Ricky', 'Martin', '342 rue berlioz', '1980-02-22', '2003-1-12', 'bnos@gmail.com', '514-222-3456', 100);
INSERT INTO Client(client_id, firstName, lastName, addr, dob, joining_date, email, phone,  branch_id)
VALUE(101002,'Mei', 'Yuan', '111 rue Young', '1990-03-11', '2003-12-24', 'trdhge@gmail.com', '514-222-6544', 101);
INSERT INTO Client(client_id, firstName, lastName, addr, dob, joining_date, email, phone,  branch_id)
VALUE(201001,'Tina', 'Ita', '675 rue William', '1983-02-22', '2004-12-26', 'bnos@gmail.com', '450-222-9877', 201);
INSERT INTO Client(client_id, firstName, lastName, addr, dob, joining_date, email, phone,  branch_id)
VALUE(202002,'Bob', 'Bush', '456 rue Young', '1995-03-11', '2005-12-28', 'trdhge@gmail.com', '450-222-5675', 202);

