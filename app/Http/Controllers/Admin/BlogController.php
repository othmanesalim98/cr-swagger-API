<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Blog\BulkDestroyBlog;
use App\Http\Requests\Admin\Blog\DestroyBlog;
use App\Http\Requests\Admin\Blog\IndexBlog;
use App\Http\Requests\Admin\Blog\StoreBlog;
use App\Http\Requests\Admin\Blog\UpdateBlog;
use App\Models\Blog;
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

class BlogController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexBlog $request
     * @return array|Factory|View
     */
    public function index(IndexBlog $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Blog::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            [''],

            // set columns to searchIn
            ['']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.blog.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.blog.create');

        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBlog $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreBlog $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Blog
        $blog = Blog::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/blogs'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/blogs');
    }

    /**
     * Display the specified resource.
     *
     * @param Blog $blog
     * @throws AuthorizationException
     * @return void
     */
    public function show(Blog $blog)
    {
        $this->authorize('admin.blog.show', $blog);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Blog $blog
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Blog $blog)
    {
        $this->authorize('admin.blog.edit', $blog);


        return view('admin.blog.edit', [
            'blog' => $blog,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBlog $request
     * @param Blog $blog
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateBlog $request, Blog $blog)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Blog
        $blog->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/blogs'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/blogs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyBlog $request
     * @param Blog $blog
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyBlog $request, Blog $blog)
    {
        $blog->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBlog $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyBlog $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Blog::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
