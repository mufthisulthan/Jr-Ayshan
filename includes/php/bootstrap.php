<?php

declare(strict_types=1);

require_once __DIR__ . '/runtime.php';

try {
    $bootstrapState = [];
    $bootstrapShop = $_SESSION['shop'] ?? null;
    $bootstrapUser = $_SESSION['user'] ?? null;

    if (isset($_SESSION['shop_id'])) {
        $bootstrapState = jr_load_state(jr_db(), (int) $_SESSION['shop_id']);
    }

    $syncKeys = jr_state_keys();
    $sessionJson = $bootstrapUser ? json_encode([
        'user' => $bootstrapUser,
        'shop' => $bootstrapShop,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : 'null';
    $stateJson = json_encode($bootstrapState, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    $keysJson = json_encode($syncKeys, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    echo "<script>window.JR_SESSION = {$sessionJson};window.JR_BOOTSTRAP_STATE = {$stateJson};window.JR_STORAGE_SYNC_KEYS = {$keysJson};(function(){var syncKeys = window.JR_STORAGE_SYNC_KEYS || [];var nativeSet = Storage.prototype.setItem;var nativeRemove = Storage.prototype.removeItem;var nativeClear = Storage.prototype.clear;var suppress = true;Object.keys(window.JR_BOOTSTRAP_STATE || {}).forEach(function(key){nativeSet.call(localStorage, key, window.JR_BOOTSTRAP_STATE[key]);});if(window.JR_SESSION){nativeSet.call(localStorage, 'jr_session', JSON.stringify(window.JR_SESSION));}else{nativeRemove.call(localStorage, 'jr_session');}syncKeys.forEach(function(key){if(!Object.prototype.hasOwnProperty.call(window.JR_BOOTSTRAP_STATE || {}, key)){nativeRemove.call(localStorage, key);}});suppress = false;function persist(action, key, value){try{fetch('/api/state.php',{method:'POST',headers:{'Content-Type':'application/json'},credentials:'same-origin',keepalive:true,body:JSON.stringify({action:action,key:key,value:value})});}catch(err){} }Storage.prototype.setItem = function(key, value){nativeSet.call(this, key, value);if(suppress){return;}if(syncKeys.indexOf(key) !== -1){persist('set', key, String(value));}};Storage.prototype.removeItem = function(key){nativeRemove.call(this, key);if(suppress){return;}if(syncKeys.indexOf(key) !== -1){persist('remove', key);}};Storage.prototype.clear = function(){nativeClear.call(this);if(suppress){return;}persist('clear');};})();</script>";
} catch (Throwable $throwable) {
    // Allow pages to render if the database is not yet configured.
}

if (!isset($_SESSION['user'])) {
    echo "<script>localStorage.removeItem('jr_session');</script>";
}
