<?php

function setCookieLogin($accessToekn, $id) {
    setcookie('login_token', $accessToekn);
    setcookie('login_userid', $id);
    verificaLogin();
}

function verificaLogin() {	
    if(!isset($_COOKIE['ninja_accessToken'])) {
        header("Location: login.html");
    }
}
