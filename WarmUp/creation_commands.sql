/*
 * creation_commands.sql
 * Copyright (C) 2018 Sebastien Bah <sebastien.bah@gmail.com>
 *
 * Distributed under terms of the MIT license.
 */


/* Branch */
CREATE TABLE Branch (
        branch_id       int not null auto_increment,
        province        varchar(255) not null,
        city            varchar(255) not null,
        street          varchar(255) not null,
        phone           varchar(255),
        fax             varchar(255),
        opening_date    date not null,
        manager_id      int not null,
        isHeadOffice    tinyint(1),
        primary key(branch_id),
        foreign key(manager_id) references Employee(title_id)
);


/* Employee */
CREATE TABLE Employee (
        employee_id     int not null auto_increment,
        firstName       varchar(255) not null,
        lastName        varchar(255) not null,
        addr            varchar(255),
        start_date      date not null,
        salary          decimal(14,2),
        email           varchar(255),
        phone           varchar(255),
        branch_id       int not null,
        position_id     int not null,
        foreign key(branch_id) references Branch(branch_id),
        foreign key(position_id) references Positions(position_id),
        primary key(employee_id)
);

/* Client */
CREATE TABLE Client (
        client_id       int not null auto_increment,
        firstName       varchar(255) not null,
        lastName        varchar(255) not null,
        addr            varchar(255) not null,
        dob             date not null,
        joining_date    date not null,
        email           varchar(255),
        phone           varchar(255),
        category        varchar(255) default 'Regular',
        branch_id       int not null,
        foreign key(branch_id) references Branch(branch_id),
        primary key(client_id)
);

/* Account */
CREATE TABLE Account (
        account_id      int not null auto_increment,
        client_id       int not null,
        account_type    varchar(255) not null,
        account_option  varchar(255) not null,
        balance         decimal(14,2),
        line_credit_limit    decimal(14,2), /*limit of line of credit and interest vary from person to person*/
        intrest_line_credit float, /* interest of line of credit depend on the sum of this interest and prime rate(listed in service form) */
        foreign key(client_id) references Client(client_id),
        primary key(account_id)
);

/* Services */
CREATE TABLE Services (
        service_id      int not null auto_increment,
        service_name    char(50),
        manager_id      int not null,
        foreign key(manager_id) references Employee(employee_id),
        primary key(service_id)
);

/* Positions
        Describes the position of an employee
        ex President, Branch Manager, General Manager for x service, Associate,...
*/
CREATE TABLE Positions (
        position_id     int,
        service_name    char(50),
        primary key(position_id)
);

/*
 Level of account 
CREATE TABLE LevelAcount (
        level_id        int not null,
        name            varchar(255),
        primary key(level_id)
);
*/

/* Interest Rate  */
/*      Vary with service, type of accound and has % associated */
CREATE TABLE InterestRate (
        service_id      int not null,
        level_id        int not null,
        rate            float,
        foreign key(service_id) references Services(service_id),
        foreign key(level_id) references LevelAcount(level_id)
);

/* Charge plans */
/*      */
CREATE TABLE ChargePlan (
        charge_id       int not null,
        draw_limit           float,
        charge_value    float, 
        primary key(charge_option)
);


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
VALUE(1001, 'John',  'Smith', '219 Rue Berlioz', '2001-02-22', 56188.12, 'awoeif@gmail.com', '514-345-3349', 100,10);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE(1002, 'Michelle',  'Green', '233 Rue Gika', '2001-02-22', 58188.12, 'regtyj@gmail.com', '514-455-8988', 100,11);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE(1011, 'Jim',  'Jones', '111 Rue Rigo', '2003-05-20', 65444.11, 'tyjdrheg@gmail.com', '514-455-6576', 101,10);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE(1012, 'Kim',  'Howard', '453 Rue Tika', '2003-05-20', 76666.21, 'jyrthe@gmail.com', '514-455-3333', 101,11);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE(2011, 'Ann',  'Roger', '219  Trudeau', '2004-08-21', 59321.34, 'jythrt@gmail.com', '450-345-3349', 201,10);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE(2012, 'Tim',  'King', '233  Tilan', '2004-08-21', 61222.11, 'iuwsd@gmail.com', '450-455-8988', 201,11);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE(2021, 'Jack',  'Atheia', '111  frank', '2005-11-29', 63324.61, 'mnbv@gmail.com', '450-455-6576', 202,10);
INSERT INTO Employee(employee_id, firstName, lastName, addr, start_date, salary, email, phone, branch_id, postion_id)
VALUE(2022, 'Kim',  'Stefen', '453  Demo', '2005-11-29', 63333.22, 'zxcvds@gmail.com', '450-455-3333', 202,11);


/*just test*/
/*
Assumptions
==========
- Branch:
        - Location is not null
        - Opening date is not null
- Employee
        - Position needs to be looked up in another table
        - Salary: decimal type to retain precision
- Client:
        -
- Position:
        - A list of title ids, with associated tileName

*/
-- vim:et
