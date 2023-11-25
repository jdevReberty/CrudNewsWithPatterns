<?php

namespace App\Http\Controllers;

use App\DTO\News\{CreateNewsDTO, UpdateNewsDTO};
use App\Services\NewsServices;
use App\Services\RequestCurrentUriServices;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(
        protected NewsServices $service,
        protected RequestCurrentUriServices $uriServices
    ){}

    public function index(Request $request) {
        $news = $this->service->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter
        );
        // dd($news);

        if($this->uriServices->isApiRequest($request)) {
            // dd($news);
            return response()->json([
                'news' => $news
            ]);
        }
        return view("pages.home", compact('news'));    
    }

    public function show(Request $request, string|int $id) {
        $response = [];
        $news = $this->service->findOne($id);
        if(!$news) {
            $response = [
                'status' => 404,
                'message' => "news not found"
            ];
        }
        $response = [
            'status' => 200,
            'news' => $news
        ];
        if($this->uriServices->isApiRequest($request)) {
            return response()->json($response);
        }

        if($response['status'] != 200) {
            return redirect()->back()->withErrors($response);
        }
        return view('edit', compact('news'));   
    }

    public function create(Request $request) {
        $user = auth()->user();

        if($this->uriServices->isApiRequest($request)) {
            return response()->json([
                'user' => $user
            ]);
        }
        return view("create", compact('user')); 
    }

    public function store(Request $request) {
        $response = [];
        try {
            $news = $this->service->create(
                CreateNewsDTO::makeFromRequest($request)
            );
            $response = [
                'status' => 200,
                'message' => "news created with success",
                'news' => $news
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        if($this->uriServices->isApiRequest($request)) {
            return response()->json($response);
        }

        if($response['status'] != 200) {
            return redirect()->back()->withErrors($response);
        } 
        return redirect()->route('home'); 
    }

    public function edit(Request $request, string|null $id) {
        $news = $this->service->findOne($id);
        $response = [];

        if(!$news) {
            $response= [
                'status' => 404,
                'message' => "news not found"
            ];
        } else {
            $response = [
                'status' => 200,
                'news' => $news
            ];
        }

        if($this->uriServices->isApiRequest($request)) {
            return response()->json($response);
        }

        if($response['status'] != 200) {
            return redirect()->back()->withErrors($response);
        }
        return view("edit", compact('news')); 
    }

    public function update(Request $request) {
        $response = [];
        try {
            $news = $this->service->update(
                UpdateNewsDTO::makeFromRequest($request)
            );
            
            $response = [
                'status' => 200,
                'message' => "news updated with success",
                'news' => $news
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        if($this->uriServices->isApiRequest($request)) {
            return response()->json($response);
        }

        if($response['status'] != 200) {
            return redirect()->back()->withErrors($response);
        }
        return redirect()->route('home');
    }

    public function delete(Request $request, string $id) {
        $response = [];
        try {
            $this->service->delete($id);
            $response = [
                'status' => 200,
                'message' => 'news deleted with success'
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        if($this->uriServices->isApiRequest($request)) {
            return response()->json($response);
        }

        if($response['status'] != 200) {
            return redirect()->back()->withErrors($response);
        }
        return redirect()->route('home');
    }
}
