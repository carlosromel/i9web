/*
 * Copyright (c) 2010, 2011 Carlos Romel <carlos.romel@gmail.com>
 */

  select *
    from selos_utilizados
   where id_tipo = 1
--     and data between '2009-01-01' and '2009-01-31'
order by data, numero_recibo

