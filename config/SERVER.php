<?php
// Archivo con la configuración a la DB

const SERVER = "localhost";
const DB = "prestamos";
const USER = "root";
const PASSWORD = "root";

const SGBD = "mysql:host=" . SERVER . ";dbname=" . DB . "";

// Método para el hash de las contraseñas
const METHOD = "AES-256-CBC";
// Clave secreta
const SECRET_KEY = '$PRESTAMOS@2020';
const SECRET_IV = '037970';
