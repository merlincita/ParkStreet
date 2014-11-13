<?php

define("DB_HOST", "localhost");   // Location Of Database
define("DB_USER", "root");        // Database User Name
define("DB_PASSWORD", "root");    // Database Password
define("DB_NAME", "parkst");      // Database Name
define("DB_PORT", 3306);          // Connection port

define("DEV_ENV", "Win");       // Win = Windows enviroment
                                // Lin = Linux env. In this case, please define the variable DB_SOCKET properly
define("DB_SOCKET", "/var/lib/mysql/mysql.sock");