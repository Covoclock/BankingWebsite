/* Employee */
CREATE TABLE IF NOT EXISTS Employee (
        employee_id     int not null auto_increment,
        firstName       varchar(255) not null,
        lastName        varchar(255) not null,
        addr            varchar(255),
        start_date      date not null,
        wage            decimal(14,2) default 0,
        email           varchar(255),
        phone           varchar(255),
        branch_id       int,
        primary key(employee_id)
);

/* Employee Schedule */
CREATE TABLE IF NOT EXISTS Schedule (
        employee_id     int not null,
        work_date       date not null,
        hour_begin      int,
        hour_end        int,
        isHoliday       tinyint(1),
        primary key(employee_id, work_date)
);

/* Employee LoginInfo */
CREATE TABLE IF NOT EXISTS EmployeeLogin (
        employee_id     int not null,
        psw             varchar(255),  
        primary key(employee_id),
        foreign key(employee_id) References Employee(employee_id)
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

/* Client */
CREATE TABLE IF NOT EXISTS Client (
        client_id       int not null auto_increment,
        firstName       varchar(255) not null,
        lastName        varchar(255) not null,
        city            varchar(255),
        province        varchar(255),
        dob             date not null,
        join_date       date not null,
        standing        tinyint(1),     -- if they can get a credit card, 1 is they can
        email           varchar(255),
        phone           varchar(255),
        category        varchar(255) default 'Regular', -- either regular or student or senior
        branch_id       int not null,
        foreign key(branch_id) references Branch(branch_id),
        primary key(client_id)
);

/* Client LoginInfo */
CREATE TABLE IF NOT EXISTS ClientLogin (
        client_id       int not null,
        psw             varchar(255),  
        primary key(client_id),
        foreign key(client_id) References Client(client_id)
);
/* Account */
/* 
   Need an account for the bank so that
   when charges/fees get processed they 
   get sent to that account 
*/
CREATE TABLE IF NOT EXISTS Account (
        account_id      int not null auto_increment,
        client_id       int not null,
        account_type    varchar(255) not null, -- checking, savings, credit 
        chargePlan_id   int,            -- for charge plan (number of max charges and montly fee)
        balance         decimal(14,2),
        credit_limit    decimal(14,2),  -- only used for credit type
        interest_rate   float,          -- positive and negative val 
        lvl             varchar(255),   -- personal, business or corporate
        transactionLeft int, -- defaults to whats in charge plan
        foreign key(client_id) references Client(client_id),
        foreign key(chargePlan_id) references ChargePlan(chargePlan_id),
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
CREATE TABLE IF NOT EXISTS ChargePlan (
        chargePlan_id   int not null,
        option_name     varchar(255),
        draw_limit      float, -- max transactions
        charge_value    float, -- periodic fees
        primary key(chargePlan_id)
);

/* Transactions */
CREATE TABLE IF NOT EXISTS Transactions (
        tid             int not null auto_increment,
        account1_id     int not null,
        account2_id     int not null,
        amount          decimal(16,2),
        dt              datetime, -- 'YYYY-MM-DD HH:MM:SS' consider this to be atomic for our situation
        primary key (tid),
        foreign key(account1_id) references Account(account_id),
        foreign key(account2_id) references Account(account_id)
);

/* Bills */
/*
  Table contains bills that have been setup and at the beginning
  of each month the server will attempt to process all the bills.
  It removes the ones that it could do and creates entries in the
  transaction table. If it fails and it is recurrent then it duplicates
  the bill (need to pay 2 bills next month to that account). If it
  fails and not recurrent just leave it there for the next month.
*/
CREATE TABLE IF NOT EXISTS Bills(
        bill_id         int not null auto_increment,
        amount          decimal(16,2),
        account1_id     int not null,
        account2_id     int not null,
        recurring       tinyint(1),
        primary key(bill_id)
);
        
-- vim:et
