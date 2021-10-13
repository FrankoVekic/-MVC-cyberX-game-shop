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

create table preorder(
id int not null primary key auto_increment,
name varchar(50) not null,
price decimal(18,2) not null,
description varchar(300),
quantity int not null,
memory_required int not null,
console varchar(50) not null,
image varchar(50)
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
('Vampyr',59.99,10,55,'PC','vampyr.jpg','Vampyr is an action role-playing video game developed by Dontnod Entertainment and 
published by Focus Home Interactive. It was released for Microsoft Windows and PlayStation 4.'),
("Marvel's Avengers",60.00,10,63,'Both','avengers.jpg',"arvel's Avengers is a 2020 action role-playing brawler video game developed by
 Crystal Dynamics and published by Square Enix's European subsidiary"),
('Dota 2',29.99,10,45,'PC','dota2.jpg',"Dota 2 is a multiplayer online battle arena video game developed and published by Valve. 
The game is a sequel to Defense of the Ancients, which was a community-created mod for Blizzard Entertainment's Warcraft III: Reign of Chaos."),
("Assassin's Creed Odyssey",60,10,70,'Both','acody.jpg',"Assassin's Creed Odyssey is an action role-playing video game developed by Ubisoft Quebec 
and published by Ubisoft. It is the eleventh major installment in the Assassin's Creed series and the successor to 2017's Assassin's Creed Origins."),
("Cyberpunk 2077",70,10,80,'PC','cyberpunk.jpg',"Cyberpunk 2077 is an action role-playing video game developed and published by CD Projekt. 
The story takes place in Night City, an open world set in the Cyberpunk universe."),
("Grand Theft Auto V",71.99,10,74,'PS4','gtav.jpg',"Grand Theft Auto V is a 2013 action-adventure game developed by Rockstar North and published by
 Rockstar Games. It is the seventh main entry in the Grand Theft Auto series, following 2008's Grand Theft Auto IV, and the fifteenth instalment overall."),
("Mount & Blade II",59.99,10,58,'PC','mbb.jpg',"Mount & Blade II: Bannerlord is a strategy action role-playing video game developed and published 
by TaleWorlds Entertainment. It is a prequel to Mount & Blade: Warband, a stand-alone expansion for the 2008 game Mount & Blade."),
('Mass Effect 3',69.99,10,63,'PC','mef.jpg',"Mass Effect Legendary Edition is a compilation of the video games in the Mass Effect trilogy: 
Mass Effect, Mass Effect 2, and Mass Effect 3."),
("Assassin's Creed Valhalla",70.99,5,75,'PC','acval.jpg',"Assassin's Creed Valhalla is a 2020 action role-playing video game developed by
 Ubisoft Montreal and published by Ubisoft. It is the twelfth major installment in the Assassin's Creed series."),
("Red Dead Redemption 2",71.99,8,83,'PC','rd2.jpg',"Red Dead Redemption 2 is a action-adventure game developed and published by Rockstar Games."),
("Resident Evil Village",65,10,60,'PS4','village.jpg',"Resident Evil Village is a 2021 first-person survival horror game developed and published
 by Capcom. It is the sequel to Resident Evil 7: Biohazard.");
 