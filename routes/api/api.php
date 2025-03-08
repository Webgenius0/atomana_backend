<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * V1 API Routes:
 */
require 'v1/auth/auth.php';                // All Auth routes
require 'v1/profile/profile.php';          // All Auth routes
require 'v1/profile/target.php';          // All Auth routes
require 'v1/admin/admin.php';              // All admin routes
require 'v1/expense/expense.php';          // All for Expense
require 'v1/method/method.php';            // payment method
require 'v1/command/command.php';          // command routes
require 'v1/property/property.php';        // property routes
require 'v1/user/user.php';                // user routes
require 'v1/sales_track/sales_track.php';  // user sales_track
require 'v1/open_house/open_house.php';    // user open_hours
require 'v1/statistics/statistics.php';    // statistics
