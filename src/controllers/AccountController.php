<?php

use Laravella\Crud\Params;

class AccountController extends DbController {

    /**
     * Let's whitelist all the methods we want to allow guests to visit!
     *
     * @access   protected
     * @var      array
     */
    protected $whitelist = array(
        'getLogin',
        'postLogin',
        'getRegister',
        'postRegister'
    );

    /**
     * Main users page.
     *
     * @access   public
     * @return   View
     */
    public function getIndex($slug = '')
    {
        $skin = Options::getSkin();
        
        $viewName = Options::getSkinName($skin, 'admin', 'accountindex');
        
        $params = new Params(false, self::SUCCESS, '', null, $viewName, 'getSelect');
        
        return View::make($viewName)->with($params->asArray());
    }

    /**
     *
     *
     * @access   public
     * @return   Redirect
     */
    public function postIndex()
    {
        // Declare the rules for the form validation.
        //
        $rules = array(
            'first_name' => 'Required',
            'last_name' => 'Required',
            'email' => 'Required|Email|Unique:users,email,' . Auth::user()->email . ',email',
        );


        // If we are updating the password.
        //
		if (Input::get('password'))
        {
            // Update the validation rules.
            //
            $rules['password'] = 'Required|Confirmed';
            $rules['password_confirmation'] = 'Required';
        }

        // Get all the inputs.
        //
		$inputs = Input::all();

        // Validate the inputs.
        //
		$validator = Validator::make($inputs, $rules);

        // Check if the form validates with success.
        //
		if ($validator->passes())
        {
            // Create the user.
            //
            $user = User::find(Auth::user()->id);
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->email = Input::get('email');

            if (Input::get('password') !== '')
            {
                $user->password = Hash::make(Input::get('password'));
            }

            $user->save();

            // Redirect to the register page.
            //
            return Redirect::to('account')->with('success', 'Account updated with success!');
        }

        // Something went wrong.
        //
        return Redirect::to('account')->withInput($inputs)->withErrors($validator->messages());
    }

    /**
     * Login form page.
     *
     * @access   public
     * @return   View
     */
    public function getLogin()
    {
        // Show the page.
        //
        $skin = Options::getSkin();
        $viewName = $skin['admin'] . '.login';
        $params = new Params(false, self::SUCCESS, '', null, $viewName, 'getLogin');

        return View::make($viewName)->with($params->asArray());
    }

    /**
     * Login form processing.
     *
     * @access   public
     * @return   Redirect
     */
    public function postLogin()
    {
        // Declare the rules for the form validation.
        //
            $rules = array(
            'email' => 'required|email',
            'password' => 'required'
        );

        // Get all the inputs.
        //
        $email = Input::get('email');
        $password = Input::get('password');

        // Validate the inputs.
        //
		$validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success.
        //
        if ($validator->passes())
        {
            // Try to log the user in.
            //
            if (Auth::attempt(array('email' => $email, 'password' => $password)))
            {
                // Redirect to the users page.
                //
                return Redirect::to('db/select/contents')->with('success', 'You have logged in successfully');
            }
            else
            {
                // Redirect to the login page.
                //
                return Redirect::to('account/login')->with('error', 'Email/password invalid.');
            }
        }

        // Something went wrong.
        //
		return Redirect::to('account/login')->withErrors($validator);
    }

    /**
     * User account creation form page.
     *
     * @access   public
     * @return   View
     */
    public function getRegister()
    {
//        // Are we logged in?
//        //
//        if (Auth::check())
//        {
//            return Redirect::to('account');
//        }
        
        $viewName = Options::get('skin', 'admin') . '.register';
        
        $segments = explode('::', $viewName);
        if (count($segments) == 3)
        {
            $viewName = $segments[1]."::".$segments[2];
        }        

        $params = new Params(false, self::SUCCESS, '', null, $viewName, 'getRegister');

        // Show the page.
        //
        return View::make($viewName)->with($params->asArray());
    }

    /**
     * User account creation form processing.
     *
     * @access   public
     * @return   Redirect
     */
    public function postRegister()
    {
        // Declare the rules for the form validation.
        //
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        );

        // Validate the inputs.
        //
		$validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success.
        //
		if ($validator->passes())
        {
            // Create the user.
            //
			$user = new User;
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->email = Input::get('email');
            $user->username = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->api_token = md5(Input::get('password'));
            $user->usergroup_id = 7;
            $user->save();

            // Redirect to the register page.
            //
            return Redirect::to('account')->with('success', 'Account created with success!');
        }

        // Something went wrong.
        //
        return Redirect::to('account/register')->withInput()->withErrors($validator);
    }

    /**
     * Logout page.
     *
     * @access   public
     * @return   Redirect
     */
    public function getLogout()
    {
        // Log the user out.
        //
		Auth::logout();

        // Redirect to the users page.
        //
		return Redirect::to('account/login')->with('success', 'Logged out with success!');
    }

}
