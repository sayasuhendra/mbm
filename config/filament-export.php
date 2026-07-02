<?php

return [
    /*
    | Filament's export pipeline uses several chained jobs. Running them on
    | the sync connection keeps small administrative exports reliable even
    | when a queue worker is not running. Set this to "database" when a
    | supervised worker is available and exports become large.
    */
    'queue_connection' => env('FILAMENT_EXPORT_QUEUE_CONNECTION', 'sync'),
];
