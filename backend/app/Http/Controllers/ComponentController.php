<?php

namespace App\Http\Controllers;

use App\Services\ComponentService;
use Illuminate\Http\Request;


class ComponentController extends Controller
{

    public function __construct(private ComponentService $componentService) {}

    public function createComponent(Request $request){
        $data = $request->validate([
            "title"    => "required|string",
            "amount"   => "required|min:0",
            "source"   => "required|in:PRODUCTION,STORAGE",
            "welding"  => "required|min:0",
            "assembly" => "required|min:0",
            "electro"  => "required|min:0",
        ]);
        $component = $this->componentService->createComponent($data);
        return response()->json(["id"=>$component->id]);
    }
}
