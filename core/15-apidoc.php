<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/. */



////////////////////
// APIDoc strings //
////////////////////
/**
 * @apiDefine Admin	Only the wiki administrator may use this call.
 */
/**
 * @apiDefine Moderator	Only users loggged with a moderator account may use this call.
 */
/**
 * @apiDefine User		Only users loggged in may use this call.
 */
/**
 * @apiDefine Anonymous	Anybody may use this call.
 */
/**
 * @apiDefine	UserNotLoggedInError
 * @apiError	UserNotLoggedInError	You didn't log in before sending this request.
 */
/**
* @apiDefine	UserNotModeratorError
* @apiError	UserNotModeratorError	You weren't loggged in as a moderator before sending this request.
*/
/**
* @apiDefine	PageParameter
* @apiParam	{string}	page	The page to operate on.
*/
////////////////////
