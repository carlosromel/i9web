/*
 * Copyright (c) 2010, 2011 Carlos Romel <carlos.romel@gmail.com>
 */

create table documentospessoa (
        iddocumentospessoa      bigint          not null        auto_increment,
        idtipodocumento         bigint          not null,
        idpessoa                bigint          not null,
        documento               varchar(100),

        primary key (iddocumentospessoa),

        foreign key (idpessoa) references pessoa (idpessoa)
            on delete restrict
            on update cascade
) engine = 'InnoDB';

create table tipodocumento (
        idtipodocumento         bigint          not null        auto_increment,
        descricao               varchar(30),
        mascara                 varchar(50),
        primary key (idtipodocumento)
) engine = 'InnoDB';

create table tipoprotocolo (
        idtipoprotocolo         bigint          not null        auto_increment,
        descricao               varchar(50),

        primary key (idtipoprotocolo)
) engine = 'InnoDB';

create table protocolo (
        idprotocolo             bigint          not null        auto_increment,
        iddocumentospessoa      bigint          not null,
        idtipoprotocolo         bigint          not null,
        idtipolivro             bigint          not null,
        idpessoa                bigint          not null,
        ordem                   integer,
        data                    date,
        natureza                varchar(250),
        apresentante            varchar(100),
        anotacoes               varchar(250),
        documento               varchar(100),

        primary key (idprotocolo),

        foreign key (iddocumentospessoa) references documentospessoa (iddocumentospessoa)
                on delete restrict
                on update cascade,

        foreign key (idtipoprotocolo) references tipoprotocolo (idtipoprotocolo)
                on delete restrict
                on update cascade,

        foreign key (idtipolivro) references tipolivro (idtipolivro)
                on delete restrict
                on update cascade,

        foreign key (idpessoa) references pessoa (idpessoa)
                on delete restrict
                on update cascade
) engine = 'InnoDB';

