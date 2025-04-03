<?php

return [
    /**
     * Define either an only or except setting as an array of route name patterns
     * You have to choose one or the other. Setting both only and except will disable filtering altogether and return all named routes
     * 
     * @return Route name
     * */
    'only' => [
        'dashboard','getService', 'getEmployee', 'getTimeSlot','appointment.create','getAppointment','getAnotheremployee','success','intent','payment','proceed','maximum.time.expire','check.user.email','status',
        'categoryservice','emp','appointments.store','service','customer.appointments','appointments','customer-appointment','appointments.show', 'verifyMail','verifySms','removegoogle'
    ],

    /**
     * Define either an only or except setting as an array of route name patterns
     * You have to choose one or the other. Setting both only and except will disable filtering altogether and return all named routes
     * You can also use asterisks as wildcards in route filters
     * 
     * @return Route not in this list
     */
    // 'except' => ['_debugbar.*', 'horizon.*', 'admin.*'],

    /**
     * You can also define groups of routes that you want make available in different places in your app, using a groups key in your config
     * 
     * @return Route By the Group
     */
    // 'groups' => [
    //     'admin' => ['admin.*', 'users.*'],
    //     'author' => ['posts.*'],
    // ],
];