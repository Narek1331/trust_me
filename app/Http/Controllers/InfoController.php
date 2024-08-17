<?php

namespace App\Http\Controllers;

use App\Services\InfoService;
use Illuminate\Http\Request;
use App\Http\Requests\Info\StoreRequest as InfoStoreRequest;
class InfoController extends Controller
{
    protected $infoService;

    public function __construct(InfoService $infoService)
    {
        $this->infoService = $infoService;
    }

    public function store(InfoStoreRequest $request)
    {
        $info = $this->infoService->store($request->search);
        return redirect()->back();
    }

}
