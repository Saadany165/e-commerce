<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure the CORS settings for your application. You can
    | configure which origins, methods, and headers are allowed to access
    | your application. By default, all origins are allowed and no other
    | restrictions are applied.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],  // مسار الـ API التي يمكن الوصول إليها

    'allowed_methods' => ['*'],  // السماح بكل الطرق (GET, POST, PUT, DELETE)

    'allowed_origins' => ['*'],  // السماح بكل النطاقات (يمكنك تحديد نطاقات معينة هنا)

    'allowed_headers' => ['*'],  // السماح بكل الهيدرز

    'exposed_headers' => [],  // الهيدرز التي سيتم إرسالها للعميل

    'max_age' => 0,  // المدة الزمنية التي يمكن للمتصفح الاحتفاظ بالـ CORS headers

    'supports_credentials' => true,  // يجب أن تكون true إذا كنت تستخدم الكوكيز أو التوكنات
];
