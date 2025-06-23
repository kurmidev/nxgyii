<?php

namespace app\component;

class Constants
{
    const DESIGNATION_SADMIN = -1;
    const CONSOLE_ID = -1;
    const USERTYPE_CONSOLE = -2;
    const USERTYPE_ADMIN = -1;
    const USERTYPE_MSO = 0;
    const USERTYPE_COMPANY = 1;
    const USERTYPE_CLIENT = 2;
    

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
    const LABEL_YESNO = [
        self::STATUS_ACTIVE => 'Yes',
        self::STATUS_INACTIVE => 'No',
    ];


    const JUMPCLOUD = "JUMPCLOUD";
    const SECEON = "SECEON";

    const AUTH_TYPE_TOKEN = 1;
    const AUTH_TYPE_LOGIN = 2;

    const METHOD_POST = "POST";
    const METHOD_GET = "GET";
    const METHOD_PUT = "PUT";

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

    const LABEL_AUTH_TYPE = [
        self::AUTH_TYPE_TOKEN => 'Token Based',
        self::AUTH_TYPE_LOGIN => 'Username & Password',
    ];

    const LABEL_METHOD_TYPE = [
        self::METHOD_POST => "POST",
        self::METHOD_GET => "GET",
        self::METHOD_PUT => "PUT",
    ];

    const LABEL_RATING = [
        1 => "Unacceptable",
        2 => "Needs Improvement",
        3 => "Meets Expectations",
        4 => "Exceeds Expectations",
        5 => "Outstanding"
    ];

    const DISPLAY_TYPE_TABLE = 1;
    const DISPLAY_TYPE_PIE_CHART = 2;
    const DISPLAY_TYPE_BAR_CHART = 3;
    const DISPLAY_TYPE_CARD = 4;
    const DISPLAY_TYPE_LINE_CHART = 5;

    const DISPLAY_TYPE_XY_BUBBLE_CHART = 6;
    const DISPLAY_TYPE_MULPLECARD = 7;

    const DISPLAY_LABEL = [
        self::DISPLAY_TYPE_TABLE => "Table",
        self::DISPLAY_TYPE_PIE_CHART => "Pie Chart",
        self::DISPLAY_TYPE_BAR_CHART => "Bar Chart",
        self::DISPLAY_TYPE_CARD => "Card",
        self::DISPLAY_TYPE_LINE_CHART => "Inline Chart",
        self::DISPLAY_TYPE_XY_BUBBLE_CHART => "Bubble Chart",
        self::DISPLAY_TYPE_MULPLECARD => "Multiple Card",
    ];

    const PRODUCT_ID_JUMPCLOUD = 1;
}