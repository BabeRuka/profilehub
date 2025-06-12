<?php

namespace BabeRuka\ProfileHub\Http\Controllers\Auth;

use BabeRuka\ProfileHub\Http\Controllers\Controller;
use BabeRuka\ProfileHub\Http\Controllers\UserDetailsController;
use App\Models\User;
use BabeRuka\ProfileHub\Models\UserDetails;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function register(Request $request)
    {

        $rules = array(
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        );
        $messages = array(
            [
                'username.required' => 'Username is required',
                'username.unique' => 'Username must be unique',
                'firstname.required' => 'First name  is required',
                'lastname.required' => 'Last name is required',
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
                'required' => 'The :attribute field is required.',
                'unique' => ':attribute is already used',
            ]
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $request->session()->flash('message', 'There was an error creating your user account. Please try again or contact an administrator!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userData = [
            'name' => $request->input('firstname') . ' ' . $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        try {

            $user = $this->create($userData);
            if (!$user) {
                Log::error('User creation returned null/false unexpectedly.', ['email' => $userData['email']]);
                return redirect()->back()->withInput()->with('error', 'Failed to create user account. Please try again.');
            }
            event(new Registered($user));
            $UserDetails = new UserDetails();
            $user_id = $user->id;
            $details = new UserDetailsController();
            $fields = $details->userDetailsModel();
            $username = $request->post('username');
            $firstname = $request->post('firstname');
            $lastname = $request->post('lastname');
            $name = $firstname . ' ' . $lastname;
            $user_email = $request->post('email');
            $user_details = $UserDetails->create([
                'username' => $username,
                'user_id' => $user_id,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $user_email,
                'password' => Hash::make($request->post('password')),
            ]);
            $details_id = $user_details->details_id;
            if (!$details_id) {
                $request->session()->flash('message', 'There was an error creating your user account. Please try again or contact an administrator!');
                return redirect()->back();
            }

            if ($request->has('user_entry') && is_array($request->input('user_entry'))) {
                foreach ($request->post('user_entry') as $key => $value) {
                    $fields->add_user_field_details($key, $user->id, $value);
                }
            }

            $this->guard()->login($user);
            return $this->registered($request, $user) ?: redirect($this->redirectPath());
        } catch (\Exception $e) {
            Log::error('User registration process failed: ' . $e->getMessage(), [
                'email' => $userData['email'] ?? $request->input('email'),
                'exception' => $e
            ]);

            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred during registration. Please try again or contact support.');
        }

    }
}
