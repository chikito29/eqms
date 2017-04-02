<?php

Artisan::command('routes', function(){
    $this->call('php artisan route:list');
});
