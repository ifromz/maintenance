<?php

namespace Stevebauman\Maintenance\Http\Controllers;

use Stevebauman\Corp\Facades\Corp;
use Stevebauman\Maintenance\Http\Requests\Auth\LoginRequest;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class AuthController extends Controller
{
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
        try
        {
            $input = $request->all();

            $remember = (bool) array_pull($input, 'remember', false);

            if ($auth = Sentinel::authenticate($input, $remember))
            {
                $message = 'Successfully logged in.';

                return redirect()->intended(route('maintenance.dashboard.index'))->withSuccess($message);
            } else if(Corp::auth($input['login'], $input['password']))
            {
                $user = Corp::user($input['login']);

                $name = explode(',', $user->name);

                $credentials = [
                    'email' => $user->email,
                    'username' => $user->username,
                    'password' => $input['password'],
                    'first_name' => (array_key_exists(1, $name) ? $name[1] : null),
                    'last_name' => (array_key_exists(0, $name) ? $name[0] : null),
                ];

                return $this->registerAndAuthenticateUser($credentials);
            }

            $errors = 'Invalid login or password.';
        }
        catch (NotActivatedException $e)
        {
            $errors = 'Account is not activated!';
        }
        catch (ThrottlingException $e)
        {
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

        if($user)
        {
            // Update the user
            Sentinel::update($user, $credentials);

            // Log them in
            Sentinel::login($user);

            $message = 'Successfully logged in.';

            return redirect()->intended('/')->withSuccess($message);
        } else
        {
            $user = Sentinel::registerAndActivate($credentials);

            if($user) {
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
