<?php

PerchUI::set_subnav([
    [
        'page'  => ['redfinch_optim', 'redfinch_optim/run'],
        'label' => 'Tasks'
    ],
    [
        'page'  => ['redfinch_optim/settings'],
        'label' => 'Settings',
        'priv'  => 'redfinch_optim.config'
    ]
], $CurrentUser);
