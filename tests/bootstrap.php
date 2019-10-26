<?php

    passthru(sprintf(
        'APP_ENV=test php "%s/../bin/console" doctrine:fixtures:load --no-interaction',
        __DIR__
    ));
    
    passthru(sprintf(
        'APP_ENV=test php "%s/../bin/console" cache:clear --no-warmup',
        __DIR__
    ));
    
    require __DIR__.'/../config/bootstrap.php';