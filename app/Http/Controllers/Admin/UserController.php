<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\RegisterUser;
use App\Mail\WelcomeMail;
use App\Models\SendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Get authenticated user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        try {
            $users = User::with('roles')->get();
            return response()->json($users);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function sendMail(Request $request)
    {
        try {
            $details = [
                'title' => 'Test Email',
                'body' => env('APP_URL') . '/register',
            ];
            \Mail::to($request->email)->send(new RegisterUser($details));
            SendMail::create(['email' => $request->email]);
            return response()->json($users);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function mails(Request $request)
    {
        try {
            $users = SendMail::all();
            return response()->json($users);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $roles = Role::pluck('name', 'name')->all();
            return response()->json($roles);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {

        try {

            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = Hash::make($request['password']);
            $this->save_image($request, 'avatar', $user, 'users', 64, 64, 's_avatar');
            $this->save_image($request, 'avatar', $user, 'users', 256, 256, 'l_avatar');
            $user->save();
            SendMail::where('email', $user->email)->update(['status' => 1]);
            DB::table('model_has_roles')->insert(['role_id' => 2, 'model_type' => 'App\Models\User', 'model_id' => $user->id]);
            $mail_data = ([
                'name' => $request['name'],
                'email' => $request['email'],
            ]);
            Mail::to($user->email)->send(new WelcomeMail($mail_data));

            return response()->json($user);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            $roles = Role::pluck('name', 'name')->all();
            $userRole = $user->roles->pluck('name', 'name')->all();
            return response()->json([$user, $roles, $userRole]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function get_user()
    {
        try {

            $user = User::where('id', auth()->id())->get();
            // $roles = Role::pluck('name', 'name')->all();
            // $userRole = $user->roles->pluck('name', 'name')->all();
            return response()->json($user);
            // return response()->json([$user, $roles, $userRole]);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        try {
            $user->name = $request['name'];
            $user->email = $request['email'];
            if (!empty($request['password'])) {
                $user->password = Hash::make($request['password']);
            }
            $this->update_image($request, 'avatar', $user, 'users', 64, 64, 's_avatar');
            $this->update_image($request, 'avatar', $user, 'users', 256, 256, 'l_avatar');
            $user->save();
            DB::table('model_has_roles')->where('model_id', $user)->delete();
            $user->assignRole($request->input('roles'));
            return response()->json($user);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $this->delete_image($user, 'users', 'image');
            $user->delete();
            return response()->json($user);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function userRole()
    {
        $users = Auth::user();

        foreach ($users->getRoleNames() as $value) {
            return response()->json($value);
        }

    }
    public function delete_image($obj, $image_path, $image_name)
    {
        try {
            $image = public_path('/images/' . $image_path . '/' . $obj->$image_name);
            if (File::exists($image)) {
                File::delete($image);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function save_image($request, $image, $obj, $image_path, $width = null, $height = null, $field = null)
    {
        try {
            if ($request->hasFile($image)) {
                $file = $request->file($image);
                $filename = time() . Str::random() . '.' . $file->getClientOriginalExtension();
                Image::make($file)->resize($width, $height)->save(public_path('/images/' . $image_path . '/' . $filename));
                $obj->$field = $filename;
                $obj->save();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update_image($request, $image, $obj, $image_path, $width = null, $height = null, $field = null)
    {
        try {
            if ($check = $request->hasFile($image)) {
                $this->delete_image($obj, $image_path, $image);
                $file = $request->file($image);
                $filename = time() . Str::random() . '.' . $file->getClientOriginalExtension();
                Image::make($file)->resize($width, $height)->save(public_path('/images/' . $image_path . '/' . $filename));
                $obj->$field = $filename;
                $obj->save();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function changeUserStatus($id)
    {
        $user = User::find($id);
        $user->status = $user->status == 0 ? 1 : 0;
        $user->save();
        return $user;
        return response()->json(['success' => 'User status change successfully.']);
    }
}
