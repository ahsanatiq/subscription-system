<?php

return [
    'secret' => env('JWT_SECRET', 'secret'),
    'ttl_minutes' => env('JWT_TTL', 60*24*365),
];
