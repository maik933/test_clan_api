<?php

$routes = [
	['GET clans', 'ClanController', 'getList'],
	['POST clans', 'ClanController', 'create'],
    ['POST clans/update/description', 'ClanController', 'updateDescription'],
    ['POST clans/delete', 'ClanController', 'delete'],
    ['POST clans/users/delete', 'ClanController', 'deleteUsers'],
    ['POST clans/users/add', 'ClanController', 'addUsers'],
    ['POST clans/deputy/up', 'ClanController', 'upDeputy'],
    ['POST clans/deputy/down', 'ClanController', 'downDeputy'],
];
