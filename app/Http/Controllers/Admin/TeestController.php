<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Teest\BulkDestroyTeest;
use App\Http\Requests\Admin\Teest\DestroyTeest;
use App\Http\Requests\Admin\Teest\IndexTeest;
use App\Http\Requests\Admin\Teest\StoreTeest;
use App\Http\Requests\Admin\Teest\UpdateTeest;
use App\Models\Teest;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TeestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexTeest $request
     * @return array|Factory|View
     */
    public function index(IndexTeest $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Teest::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'uuid', 'failed_at'],

            // set columns to searchIn
            ['id', 'uuid', 'connection', 'queue', 'payload', 'exception']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.teest.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.teest.create');

        return view('admin.teest.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTeest $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreTeest $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Teest
        $teest = Teest::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/teests'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/teests');
    }

    /**
     * Display the specified resource.
     *
     * @param Teest $teest
     * @throws AuthorizationException
     * @return void
     */
    public function show(Teest $teest)
    {
        $this->authorize('admin.teest.show', $teest);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Teest $teest
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Teest $teest)
    {
        $this->authorize('admin.teest.edit', $teest);


        return view('admin.teest.edit', [
            'teest' => $teest,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTeest $request
     * @param Teest $teest
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateTeest $request, Teest $teest)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Teest
        $teest->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/teests'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/teests');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyTeest $request
     * @param Teest $teest
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyTeest $request, Teest $teest)
    {
        $teest->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyTeest $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyTeest $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Teest::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
