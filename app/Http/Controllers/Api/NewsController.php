<?php

namespace App\Http\Controllers\Api;

use App\DTO\News\{CreateNewsDTO, UpdateNewsDTO};
use App\Http\Controllers\Controller;
use App\Services\NewsServices;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(
        protected NewsServices $service
    ){}

    public function index(Request $request) {
        $news = $this->service->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 3),
            filter: $request->filter
        );
        $filter = [$request->get('filter', '')];

        return response()->json([
            'news' => $news->items(),
            'filter' => $filter,
        ]); 
    }

    public function show(Request $request, string|int $id) {
        $news = $this->service->findOne($id);
        if(!$news) {
            return response()->json([
                'status' => 404,
                'message' => "news not found"
            ]);
        }
        return response()->json([
            'status' => 200,
            'news' => $news
        ]); 
    }

    public function create() {
        $user = auth()->user();

        return response()->json([
            'user' => $user
        ]);
    }

    public function store(Request $request) {
        try {
            $news = $this->service->create(
                CreateNewsDTO::makeFromRequest($request)
            );
            return response()->json([
                'status' => 200,
                'message' => "news created with success",
                'news' => $news
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }

    public function edit(string|null $id) {
        $news = $this->service->findOne($id);

        if(!$news) {
            return response()->json([
                'status' => 404,
                'message' => "news not found"
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'news' => $news
            ]);
        }
    }

    public function update(Request $request) {
        try {
            $news = $this->service->update(
                UpdateNewsDTO::makeFromRequest($request)
            );
            
            return response()->json([
                'status' => 200,
                'message' => "news updated with success",
                'news' => $news
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete(Request $request, string $id) {
        try {
            $this->service->delete($id);
            return response()->json([
                'status' => 200,
                'message' => 'news deleted with success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ]);
        }
    }
}
