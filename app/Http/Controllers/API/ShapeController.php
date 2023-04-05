<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Shape;
use App\Models\Draw;
use App\Models\DrawShape;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Http\Resources\DrawResource;
use App\Http\Resources\ShapeResource;
use Illuminate\Http\JsonResponse;


class ShapeController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
    $shapes = Shape::where('user_id', $request->user()->id)->get();
    return $this->sendResponse(DrawResource::collection($shapes), 'Shapes retrieved successfully.');
    }

    public function show(Request $request, $id): JsonResponse
    {
    $shapes = Shape::where('user_id', $request->user()->id)->where('user_id', $id)->get();
    return $this->sendResponse(DrawResource::collection($shapes), 'Shape retrieved successfully.');
    }

    public function create(Request $request, $shape, $attrib, $color): JsonResponse
    {
        $input = [
            'type' => $shape,
            'attrib' => $attrib,
            'user_id' => $request->user()->id,
            'color' => $color
        ];
        $shape = Shape::create($input);
        return $this->sendResponse(new ShapeResource($shape), 'Shape created successfully.');
    }

    public function store(Request $request, $name, $shapeid, $x, $y): JsonResponse
    {
        if(isset($name))
        {
            $draw = Draw::where('name', $name)->first();
            if(is_null($draw))
            {
                $drawDetails = [
                    'name' => $name,
                    'user_id' => $request->user()->id

                ];
                $draw = Draw::create($drawDetails);
            }
            $input = [
                'shape_id' => $shapeid,
                'draw_id' => $draw->id,
                'x' => $x,
                'y' => $y
            ];
            DrawShape::create($input);
            return $this->sendResponse('', 'ShapeToDraw created successfully.');

        }
        else
        {
            return $this->sendResponse('', 'Error: Draw name is empty.');
        }





    }

}
