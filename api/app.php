<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 6/4/16
 * Time: 1:12 PM
 */

\Slim\Slim::registerAutoloader();

global $app;

if(!isset($app))
    $app = new \Slim\Slim();

$app->response->headers->set('Access-Control-Allow-Credentials',  'true');

$app->response->headers->set('Content-Type', 'application/json');

/* Starting routes */

$app->get('/feedbacks/:user_id/:Id','getFeedbacks');
$app->get('/feedbacks/:user_id/:Id/count','getFeedbackCounts');
$app->post('/feedbacks/:user_id/:id', 'saveFeedback');

/* Ending Routes */

$app->run();