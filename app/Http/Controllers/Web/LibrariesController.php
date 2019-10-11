<?php

namespace App\Http\Controllers\Web;

use Cache;
use App\Http\Controllers\Controller;
use App\Library;
use App\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use App\Support\Enum\LibraryStatus;

use App\Repositories\Library\LibraryRepository;
use App\Http\Requests\Library\CreateLibraryRequest;
use App\Http\Requests\Library\UpdateLibraryRequest;
use Illuminate\Http\Request;

class LibrariesController extends Controller
{
    private $libraries;

    public function __construct(LibraryRepository $libraries)
    {
        $this->middleware('auth');
        $this->middleware('permission:library.manage');
        $this->libraries = $libraries;
    }

    public function index()
    {
        $libraries = $this->libraries->paginate(
            $perPage = 20,
            Input::get('search'),
            Input::get('status')
        );

        $statuses = ['' => 'All'] + LibraryStatus::lists();

        return view('library.index', compact('libraries', 'statuses'));
    }

    public function create(Request $req)
    {
        $type = $req->query('type');
        $edit = false;

        if($type =='finalbook'){
            return view('library.add-edit', compact('edit'));
        } else {
            return view('library.add-edit-book', compact('edit'));
        }
    }

    public function store(CreateLibraryRequest $request)
    {
        $this->libraries->create($request->all());

        return redirect()->route('library.index')
            ->withSuccess('Library created');
    }

    public function edit(Library $library, Request $req)
    {
        $type = $req->query('type');
        $edit = true;

        if($type =='finalbook'){
            return view('library.add-edit', compact('edit', 'library'));
        } else {
            return view('library.add-edit-book', compact('edit', 'library'));
        }
    }

    public function update(Library $library, UpdateLibraryRequest $request)
    {
        $this->libraries->update($library->id, $request->all());

        return redirect()->route('library.index')
            ->withSuccess('Library updated');
    }

    public function delete(Library $library)
    {
        // if (! $library->removable) {
        //     throw new NotFoundHttpException;
        // }

        $this->libraries->delete($library->id);

        Cache::flush();

        return redirect()->route('library.index')
            ->withSuccess('Library deleted');
    }
}