/*
 * Copyright (c) 2010, 2011 Carlos Romel <carlos.romel@gmail.com>
 */

create database i9web;
grant all privileges on i9web.* to i9web identified by 'i9webmaster';

use i9web;
source criar.sql
source povoar.sql

