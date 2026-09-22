<?php

return [
    /**
     * When enabled, only the address in `email` will receive real external
     * mail delivery (Resend). All other recipients will have external
     * delivery suppressed and an informational log entry will be written.
     */
    'enabled' => env('PROTOTYPE_EMAIL_MODE', true),

    // The single address that may receive real external mail during prototype mode.
    'email' => env('PROTOTYPE_EMAIL_ADDRESS', 'maccogoth@gmail.com'),
];
