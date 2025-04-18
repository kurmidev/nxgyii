<?php

namespace app\component;

class Constants
{
    const DESIGNATION_SADMIN = -1;
    const CONSOLE_ID = -1;
    const USERTYPE_CONSOLE = -2;
    const USERTYPE_ADMIN = -1;
    const USERTYPE_MSO = 0;
    const USERTYPE_CLIENT = 1;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_DELETED = -1;

    const OPEN = 1;
    const ON_HOLD = 2;
    const CLOSED = 3;

    const PRIORITY_LOW = 1;
    const PRIORITY_MEDUIM = 2;
    const PRIORITY_HIGH = 3;

    const PREFIX_DESIG = "DN";
    const PREFIX_COMPANY = "CMP";
    const PREFIX_PRODUCT = "PRD";

    const PREFIX_TICKET = "NXGCM";

    const CAT_TICKETS = 1;

    const LABEL_STATUS = [
        self::STATUS_INACTIVE => 'In Active',
        self::STATUS_ACTIVE => 'Active',
    ];

    const JUMPCLOUD = "JUMPCLOUD";
    const SECEON = "SECEON";

    const SERVICE_PROVIDER = [
        self::JUMPCLOUD => self::JUMPCLOUD,
        self::SECEON => self::SECEON,
    ];
    const ATTRIB_FOR = [
        "HEADER" => "HEADER",
        "BODY" => "BODY",
        "ENCRPT_KEY" => "ENCRPT_KEY"
    ];

    const LABEL_COMPLAINT_STATUS = [
        self::OPEN => 'OPEN',
        self::ON_HOLD => 'On Hold',
        self::CLOSED => 'Closed',
    ];

    const LABEL_PRIORITY = [
        self::PRIORITY_LOW => 'Low',
        self::PRIORITY_MEDUIM => 'Medium',
        self::PRIORITY_HIGH => 'High',
    ];

    const LABEL_CATEGORY_TYPE = [
        self::CAT_TICKETS => 'Tickets',
    ];

    const SHOW_MINE_IMAGES = [
        "pdf" => "pdf.svg",
        "html" => "folder-document.svg",
        "xlsx" => "doc.svg",
        "xls" => "doc.svg",
        "jpeg" => "tif.svg",
        "png" => "tif.svg",
        "gif" => "tif.svg",
        "zip" => "folder-document.svg",

    ];

}