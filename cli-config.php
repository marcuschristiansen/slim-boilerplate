<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// cli-config.php
require_once __DIR__ . "/config/bootstrap.php";


return ConsoleRunner::createHelperSet($entityManager);
