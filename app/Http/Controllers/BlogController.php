<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Blog;
use App\Http\Resources\Blog as BlogResource;
use Illuminate\Support\Facades\Validator;

class BlogController extends BaseController
{
    /** @OA\Get(
     *      path="/api/blogs",
     *      operationId="blogs",
     *      description="all blogs",
     *      tags={"blogs"},
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     */
    public function index()
    {
        $blogs = Blog::all();
        return $this->sendResponse(BlogResource::collection($blogs), 'Posts fetched.');
    }


    /** @OA\Post(
     *      path="/api/blogs",
     *      operationId="add",
     *      description="Add blog",
     *      tags={"blogs"},
     *   @OA\RequestBody(
     *       @OA\JsonContent(),
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               type="object",
     *               required={"title", "description"},
     *               @OA\Property(property="title",type="string"),
     *               @OA\Property(property="description", type="string"),
     *           )
     *       )
     *   ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $blog = Blog::create($input);
        return $this->sendResponse(new BlogResource($blog), 'Post created.');
    }

    public function show($id)
    {
        $blog = Blog::find($id);
        if (is_null($blog)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new BlogResource($blog), 'Post fetched.');
    }

    /** @OA\Post(
     *      path="/api/blogs/{id}",
     *      operationId="update",
     *      description="update blog",
     *      tags={"blogs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *          required=true,
     *      ),
     *   @OA\RequestBody(
     *       @OA\JsonContent(),
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               type="object",
     *               required={"title", "description"},
     *               @OA\Property(property="title",type="string"),
     *               @OA\Property(property="description", type="string"),
     *           )
     *       )
     *   ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     */
    public function update(Request $request,$id)
    {
        $input = $request->all();
        $blog = Blog::find($id);
      
        if (!$blog) {
            return $this->sendError("Blog Not found");
        }


        $validator = Validator::make($input, [
            'title' => '',
            'description' => ''
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $blog->title = $input['title'];
        $blog->description = $input['description'];
        $blog->save();

        return $this->sendResponse(new BlogResource($blog), 'Post updated.');
    }


    /** @OA\Delete(
     *      path="/api/blogs/{id}",
     *      operationId="delete",
     *      description="delete blog",
     *      tags={"blogs"},
     *        @OA\Parameter(
     *         name="id",
     *         in="path",
     *          required=true,
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="not found"
     *      ),
     *  )
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}
