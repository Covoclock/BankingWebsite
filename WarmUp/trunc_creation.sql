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
        primary key(branch_id),
);

ALTER TABLE Employee 	ADD FOREIGN KEY (branch_id) REFERENCES Branch(branch_id);
ALTER TABLE Branch 	ADD FOREIGN KEY (manager_id) REFERENCES Employee(employee_id);

