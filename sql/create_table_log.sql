drop table log;
create table log( 
    id       mediumint unsigned not null auto_increment,
    timelog date,
    user_id int(50),
    katasa  varchar(50),
    iro varchar(50),
    ryo varchar(50),
    result varchar(50),
    primary key(id)
);
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-16', '2', '8', '4', '1', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-17', '2', '8', '1', '2', '2');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-18', '2', '8', '1', '1', '2');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-19', '2', '8', '3', '3', '1');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-20', '2', '8', '2', '2', '2');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-21', '1', '1', '3', '2', '1');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-21', '2', '8', '8', '3', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-22', '2', '8', '7', '3', '1');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-23', '1', '1', '3', '2', '1');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-23', '1', '1', '7', '3', '1');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-23', '2', '8', '2', '1', '2');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-24', '2', '8', '5', '2', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-24', '1', '6', '6', '2', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-24', '1', '3', '8', '1', '3');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-24', '1', '2', '4', '3', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-25', '1', '7', '4', '3', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-25', '1', '5', '2', '2', '3');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-25', '1', '4', '2', '2', '4');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-25', '2', '8', '1', '2', '2');

