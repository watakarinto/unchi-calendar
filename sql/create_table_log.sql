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
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2021-01-08', '1', '5', '1', '2', '3');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2021-01-07', '1', '4', '2', '2', '4');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2021-01-06', '1', '3', '3', '2', '3');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2021-01-06', '1', '2', '1', '2', '2');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2021-01-05', '1', '4', '3', '2', '3');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2021-01-05', '1', '2', '3', '1', '2');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2021-01-04', '1', '4', '8', '3', '3');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2021-01-03', '1', '2', '4', '2', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2021-01-03', '1', '3', '4', '1', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2021-01-03', '1', '5', '3', '1', '3');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2021-01-02', '1', '5', '5', '2', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2021-01-02', '1', '6', '1', '3', '2');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2021-01-01', '1', '7', '2', '3', '1');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2021-01-01', '1', '6', '2', '2', '2');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-31', '1', '4', '2', '2', '4');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-30', '1', '3', '1', '3', '3');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-29', '1', '1', '3', '2', '1');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-29', '1', '1', '4', '1', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-28', '1', '5', '7', '3', '3');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-28', '1', '5', '3', '3', '3');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-27', '1', '7', '6', '3', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-26', '1', '7', '1', '2', '1');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-20', '1', '5', '6', '3', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-19', '1', '6', '4', '2', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-18', '1', '1', '7', '2', '1');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-18', '1', '1', '1', '1', '1');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-17', '1', '2', '1', '3', '2');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-16', '1', '2', '2', '2', '2');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-15', '1', '6', '7', '2', '2');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-14', '1', '5', '7', '3', '3');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-13', '1', '7', '5', '2', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-12', '1', '6', '3', '1', '2');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-11', '1', '7', '1', '3', '1');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-10', '1', '4', '4', '2', '0');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-10', '1', '5', '3', '2', '3');
insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-22', '1', '5', '6', '2', '0');