<?php
    // Path: Utilities\preventDirectAccess.php

    // prevent direct access to this file by redirecting to index.php
    if(!defined('LOADER')){
        header("Location: /");
        return;
    }

?>