<?php

session_start();
session_destroy();

header('location: ../views/user/landing_page');
