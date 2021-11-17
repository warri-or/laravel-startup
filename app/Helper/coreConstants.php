<?php

/*================================= Role ============================================= */
const SUPER_ADMIN = 0;
const USER_ADMIN = 1;
const USER = 2;
/*================================= End Of Role ============================================= */

/*================================= Module ============================================= */
const MODULE_SUPER_ADMIN = 0;
const MODULE_USER_ADMIN = 1;
const MODULE_USER = 2;

const MODULES = array(
    MODULE_SUPER_ADMIN => 'Super Admin Module',
    MODULE_USER_ADMIN => 'Admin Module',
    MODULE_USER => 'User',
);

const ROLES = array(
    SUPER_ADMIN => 'Super Admin',
    USER_ADMIN => 'Admin',
    USER => 'User',
);

/*================================= Status ===================================== */


const INACTIVE = 0;
const ACTIVE = 1;
const STATUS_SUSPENDED = 2;
const STATUS_BLOCKED = 3;
const STATUS_CANCELLED = 4;
const STATUS_FAILED = 5;


//transaction status
const PROCESSING = 0;
const CONFIRMED = 1;
const NOTIFIED = 2;
const COMPLETED = 3;
const FAILED = 4;
const REJECTED = 5;
const EXPIRED = 6;
const BLOCKED = 7;
const REFUNDED = 8;
const VOIDED = 9;

//product statuses
const PRODUCT_DRAFT = 2;

/*================================= End Of Status ===================================== */


/*================================= Combination Type ===================================== */
const COLOR_ID = 1;
const SIZE_ID = 2;

//product combination media type enums
const INTERNAL_IMAGE = 'internal_image';
const EXTERNAL_IMAGE = 'external_image';
const VIDEO_URL = 'video_url';
const _360_URL = '360_url';

/*================================= End Of Combination Type ===================================== */

// shipped product
const IS_SHIPPED_ITEM = 1;

/*================================= Payment Status ===================================== */
const PAYMENT_NOT_DONE = 0;
const PAYMENT_DONE = 1;
const PAYMENT_IN_PROGRESS = 2;
const PAYMENT_CANCEL = 3;

const PAYMENT_PURPOSE_1 = 1;
const PAYMENT_PURPOSE_2 = 2;
const PAYMENT_PURPOSE_3 = 3;

const PAYMENT_PURPOSES = array(
    PAYMENT_PURPOSE_1 => 'Payment Purpose 1',
    PAYMENT_PURPOSE_2 => 'Payment Purpose 2',
    PAYMENT_PURPOSE_3 => 'Payment Purpose 3',
);



const CARD_BRAIN_TREE = 1;
const CARD_STRIPE = 2;
const CARD_PAYPAL = 3;
const BTC = 10;

const PAYMENT_METHODS = array(
    CARD_BRAIN_TREE => 'Braintree',
    CARD_STRIPE => 'Stripe',
    CARD_PAYPAL => 'Paypal',
    BTC => 'BTC',
);

CONST MESSAGING_TYPE_USER = 1;
CONST MESSAGING_TYPE_ADMIN = 2;

/*================================= Payment Status ===================================== */

/*================================= Settings ===================================== */
const SORT_BY_LOWEST_PRICE = 1;
const SORT_BY_HIGHEST_PRICE = 2;
const SORT_BY_NEWEST = 3;

const GLOBAL_PAGINATION = 20;
const MYSQL_DATE_FORMAT = 'Y-m-d h:i:s';
const MYSQL_DATE_WITHOUT_TIME = 'Y-m-d';

//users table created_by column value definition
const SEEDUSER = 0;
/*================================= Settings ===================================== */

/*================================= Notification ===================================== */
const NOTIFICATION_BIDDING = 10;
/*================================= Notification ===================================== */

/*================================= Auction Paginate ===================================== */
const AUCTION_PAGINATE = 10 ;
const AUCTION_PAGINATE_WEB = 10 ;
/*================================= Auction Paginate ===================================== */

const BTC_ADDRESS_ACTIVE = 1;
const BTC_ADDRESS_EXPIRED = 2;
