<?php

session_start();
//Database
include 'app/Database/Database.php';

//Model
include 'app/Models/Admin/HomeModel.php';
include 'app/Models/Admin/UserModel.php';
//Controller
include 'app/Controllers/Admin/ControllerAdmin.php';
include 'app/Controllers/Admin/HomeController.php';
include 'app/Controllers/Admin/LoginController.php';
include 'app/Controllers/Admin/UserController.php';

const BASE_URL = "http://localhost/DuAn1/" ;
//Router
include 'router/web.php';

// echo password_hash("123", PASSWORD_BCRYPT);