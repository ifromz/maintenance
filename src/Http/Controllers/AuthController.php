<?php

namespace Stevebauman\Maintenance\Http\Controllers;

use Adldap\Contracts\Adldap;
use Adldap\Models\User;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Stevebauman\Maintenance\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    /**
     * @var Adldap
     */
    protected $adldap;

    /**
     * Constructor.
     *
     * @param Adldap $adldap
     */
    public function __construct(Adldap $adldap)
    {
        $this->adldap = $adldap;
    }

    /**
     * Displays the login page.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('maintenance::auth.login.index');
    }

    /**
     * Processes logging in a user.
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function authenticate(LoginRequest $request)
    {
        try {
            $input = $request->all();

            $remember = (bool) array_pull($input, 'remember', false);

            if ($auth = Sentinel::authenticate($input, $remember)) {
                $message = 'Successfully logged in.';

                return redirect()->intended(route('maintenance.dashboard.index'))->withSuccess($message);
            } elseif ($this->adldap->authenticate($input['login'], $input['password'])) {
                $user = $this->adldap->users()->find($input['login']);

                if ($user instanceof User) {
                    $name = explode(',', $user->getName());

                    $credentials = [
                        'email'      => $user->getEmail(),
                        'username'   => $user->getAccountName(),
                        'password'   => $input['password'],
                        'first_name' => (array_key_exists(1, $name) ? $name[1] : null),
                        'last_name'  => (array_key_exists(0, $name) ? $name[0] : null),
                    ];

                    return $this->registerAndAuthenticateUser($credentials);
                }
            }

            $errors = 'Invalid login or password.';
        } catch (NotActivatedException $e) {
            $errors = 'Account is not activated!';
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();

            $errors = "Your account is blocked for {$delay} second(s).";
        }

        return redirect()->back()->withErrors($errors);
    }

    /**
     * Logs the user out.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Sentinel::logout();

        $message = 'Successfully logged out.';

        return redirect()->route('maintenance.login.index')->withSuccess($message);
    }

    /**
     * Registers and authenticates a user by the specified credentials.
     *
     * @param array $credentials
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function registerAndAuthenticateUser(array $credentials)
    {
        $model = Sentinel::createModel();

        // See if the LDAP user already has an account first
        $user = $model->where('email', $credentials['email'])->first();

        if ($user) {
            // Update the user
            Sentinel::update($user, $credentials);

            // Log them in
            Sentinel::login($user);

            $message = 'Successfully logged in.';

            return redirect()->intended('/')->withSuccess($message);
        } else {
            $user = Sentinel::registerAndActivate($credentials);

            if ($user) {
                $user->username = $credentials['username'];
                $user->save();

                Sentinel::login($user);

                $message = 'Successfully logged in.';

                return redirect()->intended('/')->withSuccess($message);
            }
        }

        $message = 'There was an issue creating your active directory account. Please try again.';

        return redirect()->route('maintenance.login.index')->withErrors($message);
    }
}
