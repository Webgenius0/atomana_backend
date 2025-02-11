<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * V1 API Routes:
 */
require 'v1/auth/auth.php';    // All Auth routes
require 'v1/profile/profile.php';    // All Auth routes
require 'v1/admin/admin.php';    // All admin routes
require 'v1/expense/expense.php'; // All for Expense
