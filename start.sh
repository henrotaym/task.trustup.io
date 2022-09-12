#!/bin/bash

./vendor/bin/sail up -d
./vendor/bin/sail php artisan migrate
./vendor/bin/sail php artisan storage:link