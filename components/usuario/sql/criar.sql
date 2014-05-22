/*
 * Copyright (c) 2011, 2012 Carlos Romel <carlos.romel@gmail.com>
 */
drop table email;
drop table usuario;

create table usuario (
    id_usuario          bigint          not null    auto_increment,
    credencial          varchar(50)     not null,
    senha               varchar(32)     not null,
    nome                varchar(256)    not null,

    primary key (id_usuario),
    
    unique (credencial)
) engine = 'InnoDB';

/*
 * Um e-mail pode ser órfão, quando vem de importações de contatos.
 */
create table email (
    id_email            bigint          not null    auto_increment,
    id_usuario          bigint,
    email               varchar(256)    not null,

    primary key (id_email),

    unique (email),

    foreign key (id_usuario) references usuario (id_usuario) 
        on update cascade
        on delete restrict
) engine = 'InnoDB';

