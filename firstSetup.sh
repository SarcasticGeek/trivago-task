#!/usr/bin/env bash
bin/console doctrine:database:drop --if-exists --force &&
bin/console doctrine:database:create &&
bin/console doctrine:schema:create &&
bin/console doctrine:fixtures:load &&
bin/console cache:clear
