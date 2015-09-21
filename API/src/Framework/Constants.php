<?php

/******************************************************************************
 * API Constants
 * 
 * 
 * Throughout the API code base, commonly used codes and values are used
 * This file defines them in memory so we can use them inside the repository
 * 
 * We should only define *global* paradigm constants here
 * Class constants should still used when applicable
 * 
 */

/******************************************************************************
 * [v]  Verb
 * 
 * HTTP(s) Verbs
 */
define('v_get', 1);
define('v_post', 2);
define('v_put', 3);
define('v_delete', 4);


/******************************************************************************
 * [t]  Type
 * 
 * The Content-Type of the request
 */
define('t_json', 1);
define('t_xml', 2);


/******************************************************************************
 * [s]  Status
 * 
 * The current status of the request
 */
define('s_new', 1);
define('s_authenticated', 2);
define('s_pending', 3);
define('s_processed', 4);
define('s_complete', 5);


/******************************************************************************
 * [p]  Protocol
 * 
 * The protocol the request was sent on
 */
define('p_http', 0);
define('p_https', 1);


/******************************************************************************
 * [r]  Response Codes
 * 
 * Request response codes
 */
define('r_invalid', 400);
define('r_unauthorized', 401);
define('r_forbidden', 403);
define('r_missing', 404);
define('r_success', 200);


/******************************************************************************
 * [i]  Internal Codes
 * 
 * Codes for internal usage only
 */
define('i_emergency', 900);
define('i_error', 901);

/******************************************************************************
 * [sx]  Property Suffix
*
* All data properties should be defined with a type
*/
define('sx_int',  1);   /* signed integers */
define('sx_bool', 2);   /* boolean values */
define('sx_str',  3);   /* string values */
define('sx_arr',  4);   /* array values */
define('sx_obj',  5);   /* object pointers */
define('sx_amt',  6);   /* amount (money) values */
define('sx_dbl',  7);   /* double value */
define('sx_lng',  8);   /* long values */


