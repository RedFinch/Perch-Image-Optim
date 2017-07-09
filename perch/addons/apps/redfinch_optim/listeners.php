<?php

$API = new PerchAPI(1.0, 'redfinch_optim');

$API->on('assets.create_image', 'RedFinchOptim_Image::onCreateImage');
