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
        branch_id       int,
        foreign key(branch_id) references Branch(branch_id),
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
        credit_limit    decimal(14,2), /*limit of line of credit and interest vary from person to person*/
        interest_rate   float, /* interest of line of credit depend on the sum of this interest and prime rate(listed in service form) */
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

/* Charge plans */
/*      */
CREATE TABLE ChargePlan (
        charge_id       int not null,
        draw_limit      float,
        charge_value    float, 
        primary key(charge_id)
);
-- vim:et
