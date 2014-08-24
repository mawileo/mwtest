create table mwt_slots (
  id int,
  name text,
  usr text,
  primary key (id)
);

insert into mwt_slots values (1,'12:00',null);
insert into mwt_slots values (2,'13:00',null);
insert into mwt_slots values (3,'14:00','user01');
insert into mwt_slots values (4,'15:00','userme');
insert into mwt_slots values (5,'16:00',null);

