#!/bin/bash

cd "$( dirname "${BASH_SOURCE[0]}" )"
nohup php artisan schedule:work --daemon > storage/logs/schedule.log &
