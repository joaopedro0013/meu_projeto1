<?php



//Defini a variavel de configura��o global.
global $config;

//Define o tipo da variavel de configura��o global.
$config = array();




//Inicializa as posi��es da variavel de configura��o global


/**
 * 
 * Configura��es base de dados
 * 
 */


//Ip ou Host name do servidor de banco de dados

$config['db_host']			=		'localhost';
$config['db_user_name']		=		'root';
$config['db_password']		=		'';
$config['db_name']			=		'site_tempo';



/*

$config['db_host']			=		'localhost';
$config['db_user_name']		=		'brbrindesbhcom_user';
$config['db_password']		=		',CyCo.T;*NX$';
$config['db_name']			=		'brbrindesbhcom_site';
*/

/**
 * 
 * Fim configura��es base de dados
 * 
 */

//Configura a url do site
//$config['URL_PATH'] = 'http://'.$_SERVER['HTTP_HOST'].'/homerocosta/v3/';


//Configura a url da area administrativa
//$config['URL_PATH_ADMIN'] = './';

//Configura o titulo das p�ginas do CMS
$config['ADM_TITLE'] = 'Gerenciador - ADMIN';

//Configura��es do arquivo php.ini
ini_set('allow_url_fopen',true);
ini_set('allow_url_include',true);
ini_set('short_open_tags',true);
error_reporting(E_ALL & ~E_NOTICE);
//set_time_limit(0);

//Configura��es de cabe�alho de resposta do servidor
@header('Content-type: text/html; charset=ISO-8859-1');
?>