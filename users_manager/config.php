<?php

const _MODULE_DEFAULT = "home";
const _ACTION_DEFAULT = "lists";

// ngan chan hanh vi truy cap truc tiep vao file
const _INCODE = true;
// thiet lap host
define('_WEB_HOST_ROOT', 'http://' . $_SERVER['HTTP_HOST'] . '/php-user/users_manager');
define('_WEB_HOST_TEMPLATES', _WEB_HOST_ROOT . '/templates');

// thiet lap path
define('_WEB_PATH_ROOT', __DIR__);
define('_WEB_PATH_TEMPLATE', _WEB_PATH_ROOT . '/templates');
