<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Transformer\UserTransformer;
use Illuminate\Http\Request;
use Validator;
use Intervention\Image\ImageManagerStatic as ImageStatic;

class UsersController extends Controller
{
    /**
     * GET /users
     * @return array
     */
    public function index()
    {
        return $this->collection(User::all(), new UserTransformer());
    }

    /**
     * GET /users/{id}
     * @param integer $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->item(User::findOrFail($id), new UserTransformer());
    }

    /**
     * POST /users
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), User::rules());

        if ($validator->fails()) { 
            return response()->json(['error' => $validator->errors()]);
        }

        $img = ImageStatic::make(base64_decode($request->input('image')));

        $imageName = time() . '.jpg';

        $img->save('avatar/'.$imageName);

        $userRequest = [
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
            'image' => 'avatar/'.$imageName,
        ];

        $user = User::create($userRequest);

        $data = $this->item($user, new UserTransformer());

        return response()->json($data, 201, [
            'Location' => route('users.show', ['id' => $user->id])
        ]);
    }

    /**
     * PUT /users/{id}
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validator = Validator::make($request->all(), User::rules());

        if ($validator->fails()) { 
            return response()->json(['error' => $validator->errors()]);
        }

        $img = ImageStatic::make(base64_decode($request->input('image')));

        $imageName = $user->image . '.jpg';
        
        $img->save('avatar/'.$imageName); 

        $userRequest = [
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
        ];

        $user->fill($userRequest);
        $user->save();
    
        return $this->item($user, new UserTransformer());
    }

    /**
     * DELETE /users/{id}
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        $user->delete();

        return response()->json([
                'data' => [
                'message' => 'Ok'
            ]
        ]);
    }
}
