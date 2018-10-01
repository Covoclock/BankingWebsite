/* Employee */
CREATE TABLE IF NOT EXISTS Employee (
        employee_id     int not null auto_increment,
        firstName       varchar(255) not null,
        lastName        varchar(255) not null,
        addr            varchar(255),
        start_date      date not null,
        salary          decimal(14,2) default 0,
        email           varchar(255),
        phone           varchar(255),
        branch_id       int,
        primary key(employee_id)
);


/* Branch */
CREATE TABLE IF NOT EXISTS Branch (
        branch_id       int not null auto_increment,
        province        varchar(255) not null,
        city            varchar(255) not null,
        street          varchar(255) not null,
        phone           varchar(255),
        fax             varchar(255),
        opening_date    date not null,
        manager_id      int ,
        isHeadOffice    tinyint(1),
        FOREIGN KEY (manager_id) REFERENCES Employee(employee_id),
        primary key(branch_id)
);

ALTER TABLE Employee 	ADD FOREIGN KEY (branch_id) REFERENCES Branch(branch_id);
-- ALTER TABLE Branch 	ADD FOREIGN KEY (manager_id) REFERENCES Employee(employee_id);

/* Client */
CREATE TABLE IF NOT EXISTS Client (
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
CREATE TABLE IF NOT EXISTS Account (
        account_id      int not null auto_increment,
        client_id       int not null,
        account_type    varchar(255) not null,
        account_option  varchar(255) not null,
        balance         decimal(14,2),
        credit_limit    decimal(14,2), 
        interest_rate   float, 
        foreign key(client_id) references Client(client_id),
        primary key(account_id)
);

/* Services */
CREATE TABLE IF NOT EXISTS Services (
        service_id      int not null auto_increment,
        service_name    char(50),
        manager_id      int not null,
        foreign key(manager_id) references Employee(employee_id),
        primary key(service_id)
);

/* Charge plans */
/*      */
CREATE TABLE IF NOT EXISTS ChargePlan (
        charge_id       int not null,
        draw_limit      float,
        charge_value    float, 
        primary key(charge_id)
);
-- vim:et
