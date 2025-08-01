<?php

return array(
    /**
     * The session driver, options: 'cookie', 'file', 'db', 'memcached', 'redis'
     */
    'driver' => 'cookie',

    /**
     * The name of the session cookie
     */
    'cookie_name' => 'fuelcid',

    /**
     * The name of the session table (if using the 'db' driver)
     */
    'table_name' => 'sessions',

    /**
     * The session cookie expiration. Set to 0 for no expiration.
     */
    'expiration_time' => 7200, // 2 hours

    /**
     * The session cookie path.
     */
    'cookie_path' => '/',

    /**
     * The session cookie domain.
     */
    'cookie_domain' => '',

    /**
     * The session cookie http_only flag.
     */
    'cookie_http_only' => true,

    /**
     * The session cookie secure flag.
     */
    'cookie_secure' => false,

    /**
     * The session ID rotation interval. Set to 0 for no rotation.
     */
    'rotation_time' => 300, // 5 minutes

    /**
     * The session ID hash method.
     */
    'id_hash_algo' => 'sha1',

    /**
     * The session data hash method.
     */
    'data_hash_algo' => 'sha1',

    /**
     * Whether to match the user agent string for the session.
     */
    'match_useragent' => true,

    /**
     * Whether to match the IP address for the session.
     */
    'match_ip' => true,

    /**
     * File driver settings
     */
    'file' => array(
        'path' => APPPATH.'tmp'.DS.'sessions',
        'gc_probability' => 5,
    ),

    /**
     * DB driver settings
     */
    'db' => array(
        'database' => null,
        'table'    => 'sessions',
        'gc_probability' => 5,
    ),

    /**
     * Memcached driver settings
     */
    'memcached' => array(
        'auto_id' => false,
        'expiration' => 7200, // 2 hours
        'servers' => array(
            array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 100),
        ),
    ),

    /**
     * Redis driver settings
     */
    'redis' => array(
        'auto_id' => false,
        'expiration' => 7200, // 2 hours
        'database' => 'default',
        'persistent' => false,
        'host' => '127.0.0.1',
        'port' => 6379,
    ),
);