/*
 * Copyright (c) 2010, 2011 Carlos Romel <carlos.romel@gmail.com>
 */
create table pessoa (
        idpessoa                bigint          not null        auto_increment,
        nome                    varchar(100)    not null,

        primary key (idpessoa)
) engine = 'InnoDB';

