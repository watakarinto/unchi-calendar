drop table unchiuser;
create table unchiuser( 
    id       mediumint unsigned not null auto_increment,
    user_name varchar(50),
    user_password varchar(50),
    user_age int,
    register date,
    primary key(id)
);
insert into unchiuser(user_name, user_password, user_age, register) values ('test0','0000', 20, '2020-01-01');
insert into unchiuser(user_name, user_password, user_age, register) values ('test1','1111', -1, '2020-02-01');
insert into unchiuser(user_name, user_password, user_age, register) values ('かぐや姫','2222', 74, '2020-02-01');
insert into unchiuser(user_name, user_password, user_age, register) values ('桃太郎','3333', 32, '2020-02-01');
insert into unchiuser(user_name, user_password, user_age, register) values ('浦島太郎','4444', 15, '2020-03-01');
insert into unchiuser(user_name, user_password, user_age, register) values ('金太郎','5555', 67, '2020-04-01');
insert into unchiuser(user_name, user_password, user_age, register) values ('一寸法師','6666', 30, '2020-05-01');
insert into unchiuser(user_name, user_password, user_age, register) values ('花咲じいさん','7777', 38, '2020-06-01');
insert into unchiuser(user_name, user_password, user_age, register) values ('Donatello K. Davis','8888', 29, '2020-02-01');
insert into unchiuser(user_name, user_password, user_age, register) values ('情報太郎','9999', 23, '2020-04-01');