/*
 * creation_commands.sql
 * Copyright (C) 2018 Sebastien Bah <sebastien.bah@gmail.com>
 *
 * Distributed under terms of the MIT license.
 */


/* Branch */
CREATE TABLE Branch (
        branch_id       int not null auto_increment,
        location        varchar(255) not null,
        phone           varchar(255),
        fax             varchar(255),
        opening_date    DATE not null,
        manager_name    varchar(255),
        manager_id      int not null,
        primary key(branch_id),
        foreign key(manager_id) references Employee(title_id)
);


/* Employee */
CREATE TABLE Employee (
        employee_id     int not null auto_increment,
        name            varchar(255) not null,
        addr            varchar(255),
        start_date      date not null,
        salary          decimal(14,2),
        email           varchar(255),
        phone           varchar(255),
        branch_id       int not null,
        position_id     int not null,
        primary key(employee_id),
        foreign key(branch_id) references Branch(branch_id),
        foreign key(position_id) references Positions(position_id)
);

/* Client */
CREATE TABLE Client (
        client_id       int not null auto_increment,
        name            varchar(255) not null,
        addr            varchar(255) not null,
        dob             date not null,
        joining_date    date not null,
        email           varchar(255),
        phone           varchar(255),
        category        /* what are the options here: old, student, --> category table or enumerate for possible values */ 
        primary key(client_id)
);

/* Account */
CREATE TABLE Account (
        account_id      int not null auto_increment,
        client_id       int not null,
        account_type    int,
        branch_id       int,
        account_option  /* type? */,
        level_id        int,
        credit_limit    decimal(14,2),
        balance         decimal(14,2),
        primary key(account_id),
        foreign key(client_id) references Client(client_id),
        foreign key(branch_id) references Branch(branch_id),
        foreign key(level_id)  references LevelAcount(level_id)
);

/* Services */
CREATE TABLE Services (
        service_id      int,
        service_name    char(50),
        primary key(service_id)
);

/* Positions */
CREATE TABLE Positions (
        position_id     int,
        service_name    char(50),
        primary key(position_id)
);

/* Level of account */
CREATE TABLE LevelAcount (
        level_id        int not null,
        name            varchar(255),
        primary key(level_id)
);

/* Interest Rate  */
/*      Vary with service, type of accound and has % associated */
CREATE TABLE InterestRate (
        service_id      int not null,
        level_id        int not null,
        rate            float,
        foreign key(service_id) reference Services(service_id),
        foreign key(level_id) references LevelAcount(level_id)
);

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
