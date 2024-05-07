<?php

session_start();
session_destroy();

header('location: Paso1.php');