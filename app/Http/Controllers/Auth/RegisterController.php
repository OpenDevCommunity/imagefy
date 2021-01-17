<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\InviteRequested;
use App\Mail\NewInviteRequest;
use App\Models\Invitation;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\RegistersUsers;
use Hash;
use Illuminate\Http\RedirectResponse;
use Mail;
use Validator;
use Carbon\Carbon;

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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * @return Application|Factory|View
     */
    public function showRegistrationForm()
    {
        $invitation_token = request()->get('invitation_token');
        $invitation = Invitation::where('invitation_token', $invitation_token)->firstOrFail();
        $email = $invitation->email;

        return view('auth.register', compact('email'));
    }

    /**
     * @return Application|Factory|View
     */
    public function requestInvintation()
    {
        return view('auth.request');
    }

    /**
     * @return RedirectResponse
     */
    public function store()
    {
        // Check if user has an existing invite request
        $exists = Invitation::where('email', request()->email)->where('accepted', '!=', 3)->first();

        if ($exists) {
            alert()->error('Existing Request!', 'Invitation to register request has already been submitted!');
            return redirect()->back();
        }

        $invitation = new Invitation(request()->all());
        $invitation->generateInvitationToken();
        $invitation->save();

        $admins = User::whereRoleIs(['administrator', 'superadministrator'])->get();

        Mail::to(request()->get('email'))->send(new InviteRequested(request()->get('email')));
        Mail::to($admins)->send(new NewInviteRequest(request()->get('email')));

        alert()->success('Request Sent', 'Invitation to register successfully requested. Please wait for registration link.');
        return redirect()->back();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        Invitation::where('email', $data['email'])->update(['registered_at' => Carbon::now()]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $userRole = Role::where('name', 'user')->first();

        $user->attachRole($userRole);

        activity('registration')->performedOn($user)->causedBy($user)->log('Registered an account');

        return  $user;
    }
}
