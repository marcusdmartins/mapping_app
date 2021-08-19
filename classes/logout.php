<?php

require_once '../services/manager_session.php';;
session_start();
session_destroy(); 

ManagerSession::excluiCookie();
echo"<script>location.href = '../index';</script>";

