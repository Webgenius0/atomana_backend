<?php

namespace App\Http\Controllers\API\V1\MyAgentEarning;

use App\Http\Controllers\Controller;
use App\Services\API\V1\MyAgentEarning\MyAgentEarningService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MyAgentEarningController extends Controller
{
    protected MyAgentEarningService $myAgentEarningService;


    public function __construct(MyAgentEarningService $myAgentEarningService)
    {
        $this->myAgentEarningService = $myAgentEarningService;
    }


    public function index()
    {
        try {
        }catch (Exception $e){
            Log::error('App\Services\API\V1\MyAgentEarning\MyAgentEarningService::index', ['error' => $e->getMessage()]);
            return $this->error(500, 'Server Error', $e->getMessage());
        }
    }
}
