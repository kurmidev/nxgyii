<?php

namespace app\component;

class Constants{
    const DESIGNATION_SADMIN = -1;
    const CONSOLE_ID = -1;
    const USERTYPE_CONSOLE = -2;
    const USERTYPE_ADMIN = -1;
    const USERTYPE_MSO = 0;
    const USERTYPE_CLIENT = 1;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -1;

    const PREFIX_DESIG = "DN";
    const PREFIX_COMPANY = "CMP";
    const PREFIX_PRODUCT = "PRD";
    const LABEL_STATUS = [
        self::STATUS_INACTIVE => 'In Active',
        self::STATUS_ACTIVE => 'Active',
    ];


}