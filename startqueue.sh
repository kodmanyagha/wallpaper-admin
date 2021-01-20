#!/bin/bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
nohup php artisan queue:work --daemon > storage/logs/queue.log &
