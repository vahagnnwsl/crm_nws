<?php

use Illuminate\Support\Facades\Route;



Route::post('/conversations/{entityUrn}/messages','ConversationController@store');

