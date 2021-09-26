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
('Pokemon',39.99,10,40,'Both','pokemon.jpg','Gotta catch them all!'),
('Spider-man',59.99,10,65,'PC','spiderman.jpg','Save the city with your favorite superhero!'),
('Biomutant',39.99,10,50,'PC','biomutant.jpg','Biomutant is an action role-playing game developed 
by Swedish developer Experiment 101 and published by THQ Nordic. The game was released on 25 May 2021
 for Microsoft Windows.'),
 ('Far Cry 6',49.99,10,65,'Both','fc6.jpg','Far Cry 6 is an upcoming first-person shooter game developed by 
Ubisoft Toronto and published by Ubisoft. It is the sixth main installment of the Far Cry series for Amazon Luna,
 Microsoft Windows.'),
 ('Battlefield V',69.99,10,70,'Both','bf5.jpg','Battlefield V is a first-person shooter video game developed 
by DICE and published by Electronic Arts.It was released worldwide for Microsoft Windows.'),
('Days Gone',49.99,10,60,'Both','daysgone.jpg','Days Gone is a 2019 action-adventure survival horror video
 game developed by Bend Studio and published by Sony Interactive Entertainment.'),
 ('Dying Light 2',59.99,10,57,'Both','dyinglight.jpg','Dying Light 2 Stay Human is an upcoming survival horror 
action role-playing game developed by Techland.'),
 ('The Medium',49.99,10,60,'PC','medium.jpg','The Medium is a psychological horror video game developed
by Bloober Team. It was released for Microsoft Windows on January 28, 2021 and was released for
 PlayStation 4 on September 3, 2021'),
 ('Scorn',59.99,10,50,'Both','scorn.jpg','Scorn is an upcoming first-person survival horror adventure video game developed
 by Ebb Software for Microsoft Windows. The game is directly inspired by the works of H. R. Giger and Zdzisław Beksiński'),
 ('Halo Infinite',69.99,10,70,'PC','haloinfinite.jpg','Halo Infinite is a first-person shooter game developed by 343 Industries 
and published by Xbox Game Studios for Microsoft Windows.'),
('Vampyr',59.99,10,55,'PC','vampyr.jpg','Vampyr is an action role-playing video game developed by Dontnod Entertainment and published by Focus Home Interactive. It was released for Microsoft Windows and PlayStation 4.');