/*
 * Copyright (c) 2010, 2011 Carlos Romel <carlos.romel@gmail.com>
 */

create table livro (
        idlivro                 bigint          not null        auto_increment,
        numero                  integer,

        primary key (idlivro)
) engine = 'InnoDB';

create table tipolivro (
        idtipolivro             bigint          not null        auto_increment,
        idlivro                 bigint          not null,
        descricao               varchar(20),

        primary key (idtipolivro),

        foreign key (idlivro) references livro (idlivro)
                on delete restrict
                on update cascade
) engine = 'InnoDB';

