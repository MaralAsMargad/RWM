<?php

session_start();

session_unset();

session_destroy();

header("Location: /rwm/movies/movies.php");

exit;