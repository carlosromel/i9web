/*
 * Copyright (c) 2010, 2011 Carlos Romel <carlos.romel@gmail.com>
 */

insert into tipo (descricao_tipo)
    select distinct tipo
      from selos_utilizados;

alter table selos_utilizados
    add column id_tipo integer
    after numero_recibo;

alter table selos_utilizados
    add foreign key (id_tipo) references tipo (id_tipo)
        on delete restrict
        on update cascade;

update selos_utilizados
   set id_tipo = (select id_tipo
                    from tipo
                   where selos_utilizados.tipo = tipo.descricao_tipo);

alter table selos_utilizados
   drop column tipo;

