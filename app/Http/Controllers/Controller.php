<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function success($data, $resource = null, $useCollection = false, $message = null)
    {
        if ($resource && $useCollection) {
            $data = $resource::collection($data);
        } elseif ($resource) {
            $data = new $resource($data);
        }

        if (! $message) {
            $message = trans('messages.success');
        }

        return response()->json([
            'message' => $message,
            'data' => $data,
        ]);
    }
}
