<?php
session_start();
if(session_destroy())
{
header("Location: login.php"); // Redirection vers login
}