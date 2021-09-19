drop database if exists cyberx;
create database cyberx default character set utf8mb4;
use cyberx;

create table games(
id int not null primary key auto_increment,
name varchar(50) not null,
price decimal(18,2) not null,
description varchar(300),
quantity int not null,
memory_required int not null,
console varchar(50) not null,
image varchar(50)
);

create table users (
id int not null primary key auto_increment,
email varchar(50) not null,
password char(60) not null,
name varchar(50) not null,
surname varchar(50) not null,
role varchar(10) not null
);

create table orders (
id int not null primary key auto_increment,
buyer int,
order_date datetime,
order_state varchar(100)
);

create table game_order (
id int not null primary key auto_increment,
orders int not null,
games int not null,
quanitity int
);

alter table game_order add foreign key (games) references games(id);
alter table game_order add foreign key (orders) references orders(id);
alter table orders add foreign key (buyer) references users(id);

insert into users (email,password,name,surname,role) values 
('admin@edunova.hr','$2y$10$WHV1bOXJTbMzrtZEIWO97.2ycbapSP0JweaAC1iP5luFC9wosSsk2','Admin','Edunova','admin'),
('oper@edunova.hr','$2y$10$WHV1bOXJTbMzrtZEIWO97.2ycbapSP0JweaAC1iP5luFC9wosSsk2','Operater','Edunova','oper');

insert into games (name,price,quantity,memory_required,console,image,description) values 
('Pokemon',39.99,10,40,'PC&PS4','pokemon.png','Gotta catch them all!'),
('Spider-man',59.99,10,65,'PC','spiderman.jpg','Save the city with your favorite superhero!');