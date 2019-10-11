<?php

namespace App\Http\Controllers\Web;

use Cache;
use App\Http\Controllers\Controller;
use App\Option;
use App\Department;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use App\Support\Enum\UserStatus;

use App\Repositories\Option\OptionRepository;
use App\Http\Requests\Option\CreateOptionRequest;
use App\Http\Requests\Option\UpdateOptionRequest;

class OptionsController extends Controller
{
    private $options;

    public function __construct(OptionRepository $options)
    {
        $this->middleware('auth');
        $this->middleware('permission:option.manage');
        $this->options = $options;
    }

    public function index()
    {
        $options = $this->options->paginate(
            $perPage = 20,
            Input::get('search'),
            Input::get('status')
        );

        $statuses = ['' => 'All'] + UserStatus::lists();

        return view('option.index', compact('options', 'statuses'));
    }

    public function create()
    {
        $edit = false;
        $departments = Department::orderBy('name', 'asc')->get();

        return view('option.add-edit', compact('edit', 'departments'));
    }

    public function store(CreateOptionRequest $request)
    {
        $this->options->create($request->all());

        return redirect()->route('option.index')
            ->withSuccess('Option created');
    }

    public function edit(Option $option)
    {
        $edit = true;
        $departments = Department::orderBy('name', 'asc')->get();

        return view('option.add-edit', compact('edit', 'option', 'departments'));
    }

    public function update(Option $option, UpdateOptionRequest $request)
    {
        $this->options->update($option->id, $request->all());

        return redirect()->route('option.index')
            ->withSuccess('Option updated');
    }

    public function delete(Option $option)
    {
        // if (! $option->removable) {
        //     throw new NotFoundHttpException;
        // }

        $this->options->delete($option->id);

        Cache::flush();

        return redirect()->route('option.index')
            ->withSuccess('Option deleted');
    }
}