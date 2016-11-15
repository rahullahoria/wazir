<?php

require_once "header.php";

include 'db.php';
require 'Slim/Slim.php';


//feedbacks resource
require_once "resources/feedbacks/saveFeedbacks.php";
require_once "resources/feedbacks/getFeedbacks.php";
require_once "resources/feedbacks/getFeedbackCounts.php";

//app
require_once "app.php";



?>