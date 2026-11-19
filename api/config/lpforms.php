<?php

return [
    // Independent LP Forms activity-history prototype. Off by default.
    // Outside local/testing environments this also requires an active
    // self-hosted Enterprise licence until legal release clearance.
    'audit_enabled' => (bool) env('LP_FORMS_AUDIT_ENABLED', false),
];
