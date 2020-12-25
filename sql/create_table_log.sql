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
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-01', '1', '2', '3', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-02', '1', '3', '1', '2', '2');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-03', '2', '3', '2', '2', '4');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-04', '1', '1', '2', '3', '2');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-05', '1', '2', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-06', '2', '2', '3', '3', '4');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-07', '1', '1', '3', '2', '2');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-08', '1', '1', '2', '2', '1');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-09', '2', '3', '2', '2', '4');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-10', '1', '3', '1', '3', '2');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-11', '1', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-13', '1', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-14', '1', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-15', '1', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-16', '1', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-17', '1', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-18', '1', '1', '2', '1', '1');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-19', '1', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-20', '1', '3', '4', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-23', '1', '4', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-24', '1', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-26', '1', '4', '4', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-27', '1', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-28', '1', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-11-29', '1', '2', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-01', '1', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-02', '1', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-02', '11', '3', '2', '1', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-03', '1', '3', '2', '2', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-04', '1', '1', '1', '1', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-05', '1', '1', '2', '2', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-06', '1', '3', '2', '2', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-07', '1', '1', '1', '1', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-08', '1', '1', '2', '1', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-09', '1', '3', '2', '1', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-10', '1', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-10', '11', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-11', '1', '3', '2', '3', '3');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-12', '1', '4', '4', '3', '4');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-13', '1', '5', '4', '3', '4');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-14', '1', '6', '4', '3', '2');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-15', '1', '6', '4', '3', '2');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-16', '1', '2', '4', '3', '2');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-17', '1', '7', '4', '3', '2');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-18', '1', '3', '4', '3', '2');
-- insert into log(timelog, user_id, katasa, iro, ryo, result) values ('2020-12-22', '11', '3', '4', '3', '2');

