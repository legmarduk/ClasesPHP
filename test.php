<?php 

require_once('user.class.php');
require_once('material.class.php');
require_once('request.class.php');
require_once('state.class.php');
require_once('state_request.class.php');

/*****CREATE******/
/*
$u = new user();
$u->name_user='pruba';
$u->lastname_1='prueba';
$u->lastname_2='prueba';
$u->rut_user= '183879057';
$u->mail = 'prueba@gmail.com';
$u->phone ='56944723952';
$u->position ='gerente';
$u->date_birth= '1993-06-04';
$u->active=1;
$u->pass=md5('123');
$u->whatsapp='+56944723952';
$u->create();
print_r($u);
*/

/*****UPDATE******/
/*  
$u = new user(4);
$u->position ='vago';
$u->update();
*/

/*
$res=$u->getUserByMail('ian.lopez.c@gmail.com');
print_r($res);
*/
//print_r($u);

/**************MATERIALS****************/
/*
$m = new material();
$m->name_material="fierro";
$m->description_material="para las otras cosas";
$m->provider_material="CAP";
$m->code_material="mv1112";
$m->unity="unidad";

$m->create();
print_r($m);
*/

/* update
$m = new material(2);
print_r($m);

$m->description_material ="Bolsa de tachuelas";
print_r("*****************");
print_r($m);
$m->update();
*/
/*
$m = new material(3);
$m->delete();
*/
/*
$m = new material();
$resultado = $m->getMaterialsByCode('mv1112');
print_r($resultado);
*/

/*
$r = new request();
$r->date_requests=getdate();
$r->comment_supervisor="";
$r->comment_panol="";
$r->id_user=1;
$r->create();
print_r($r);
*/
/*
$r= new request(1);
$r->comment_supervisor="comentario supervisor prueba";
$r->comment_panol="comentario panol prueba";
$r->id_user=3;
$r->update();
print_r($r);
*/
/*
$r= new request(3);
$r->delete();
print_r($r);
*/
/*
$s = new state(2);
$s->delete();*/

/*
$s = new state();
$resultado = $s->getAllStates();
print_r($resultado);*/

$sr = new state_request();

$sr->date_change_state = getdate();
$sr->id_state = 3;
$sr->id_request =1;
$sr->id_user=1;
print_r($sr);
$sr->create();
?>   

