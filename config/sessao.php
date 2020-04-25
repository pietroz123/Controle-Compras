<?php

    // Inicia a sessão
    if (!isset($_SESSION) || !is_array($_SESSION)) {
        session_start();
    }