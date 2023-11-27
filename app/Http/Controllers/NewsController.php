<?php

namespace App\Http\Controllers;

use App\DTO\News\{CreateNewsDTO, UpdateNewsDTO};
use App\Models\News;
use App\Services\NewsServices;
use App\Services\RequestCurrentUriServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function __construct(
        protected NewsServices $service,
        protected RequestCurrentUriServices $uriServices,
    ){}

    public function index(Request $request) {
        $news = $this->service->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 3),
            filter: $request->filter
        );
        $filterValues = '';
        $filter = [$request->get('filter', '')];
        foreach ($filter as $key => $value) {
            $filterValues == '' ? $filterValues .= $value : $filterValues .= ' '.$value;
        }

        return view("pages.home", compact('news', 'filter', 'filterValues'));    
    }

    public function show(string|int $id) {
        $response = [];
        $news = $this->service->findOne($id);
        if(!$news) {
            return redirect()->back()->withErrors(['errors' => "news not found"]);
        }
        return view('pages.news.show', compact('news'));   
    }

    public function create() {
        return view("pages.news.create"); 
    }

    public function store(Request $request) {
        try {
            $this->service->create(
                CreateNewsDTO::makeFromRequest($request)
            );
            return redirect()->route('news.index'); 
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function edit(Request $request, string|null $id) {
        $news = $this->service->findOne($id);
        if(!$news) {
            return redirect()->back()->withErrors(['errors' => "news not found"]);
        } 
        return view("pages.news.edit", compact('news')); 
    }

    public function update(Request $request) {
        try {
            $this->service->update(
                UpdateNewsDTO::makeFromRequest($request)
            );
            return redirect()->route('news.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }

    public function delete(string $id) {
        try {
            $this->service->delete($id);
            return redirect()->route('news.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errors' => $e->getMessage()]);
        }
    }
}
