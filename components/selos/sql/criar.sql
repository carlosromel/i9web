/*
 * Copyright (c) 2010, 2011 Carlos Romel <carlos.romel@gmail.com>
 */

create table tipo (
    id_tipo             integer         not null auto_increment primary key,
    descricao_tipo      varchar (50)    not null unique
) engine = 'InnoDB';

create table selos_utilizados (
    numero_recibo       varchar (20),
    tipo                varchar (100),
    data                date,
    cobrar_selo         varchar (50),
    codigo_oficial      varchar (20),
    valor_emolumento    numeric (10,2),
    valor_de_referencia numeric (10,2),
    selo                varchar (21)
) engine = 'InnoDB';

