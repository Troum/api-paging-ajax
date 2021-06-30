<?php

namespace App\Http\Controllers;

use App\Models\Tile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TilesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * @return JsonResponse
     */
    public function index()
    {
        if (request()->hasHeader('X-Dashboard')) {
            $tiles = Tile::all();
        } else {
            $tiles = Tile::orderBy('created_at', 'desc')
                ->paginate(2);
        }
        return response()->json([
            'tiles' => $tiles
        ], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $tile = new Tile();
            $tile->store($request);
            return response()->json([
                'success' => 'Плитка сохранена успешно'
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'error' => 'Произошла ошибка номер ' .
                $exception->getCode() .
                '. Для подробной информации проверьте логи'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        try {
            $tile = Tile::find($id);
            return response()->json([
                'tile' => $tile
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'error' => 'Произошла ошибка номер ' .
                $exception->getCode() .
                '. Для подробной информации проверьте логи'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        try {
            $tile = Tile::find($id);
            if ($tile->name !== $request->name) {
                $tile->name = $request->name;
                $tile->save();
                return response()->json([
                    'success' => 'Плитка изменена успешно',
                ], Response::HTTP_OK);
            }
            return response()->json([
                'success' => 'Плитка не была изменена: новых данных не найдено'
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'error' => 'Произошла ошибка номер ' .
                $exception->getCode() .
                '. Для подробной информации проверьте логи'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $tile = Tile::find($id);
            $tile->delete();
            $tiles = Tile::all();
            return response()->json([
                'success' => 'Плитка успешно удалена',
                'tiles' => $tiles,
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'error' => 'Произошла ошибка номер ' .
                $exception->getCode() .
                '. Для подробной информации проверьте логи'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
