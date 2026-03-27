create table csc30025login(
    id int auto_increment primary key,
    username varchar(30),
    password varchar(100),
    admin boolean default false);