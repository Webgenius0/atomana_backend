<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * V1 API Routes:
 */
require 'v1/auth/auth.php';                        // All Auth routes
require 'v1/profile/profile.php';                  // All Auth routes
require 'v1/profile/target.php';                   // All Auth routes
require 'v1/admin/admin.php';                      // All admin routes
require 'v1/expense/expense.php';                  // All for Expense
require 'v1/agent_earning/agent_earning.php';      // All for agent-earning
require 'v1/method/method.php';                    // payment method
require 'v1/command/command.php';                  // command routes
require 'v1/property/property.php';                // property routes
require 'v1/user/user.php';                        // user routes
require 'v1/sales_track/sales_track.php';          // user sales_track
require 'v1/open_house/open_house.php';            // user open_hours
require 'v1/statistics/statistics.php';            // statistics
require 'v1/vendor_category/vendor_category.php';  // vendor_category
require 'v1/vendor/vendor.php';                    // vendor
require 'v1/vendor_review/vendor_review.php';      // vendor_review
require 'v1/ai/chat.php';                          // my-chat
require 'v1/password_list/password_list.php';      // password_list
require 'v1/shared_note/shared_note.php';          // shared_note
require 'v1/contract/contract.php';                // contract
