<?php

namespace App\Http\Controllers\Auth;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Controllers\Home\BaseHomeController;

class AuthController extends BaseHomeController
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|max:255|confirmed',
        ], [
            'email.unique' => 'Данный Email уже занят',
            'email.required' => 'Поле Email обязательно для заполнения',
            'email.max' => 'Максимальная длинна Email 255 символов',

            'name.required' => 'Поле Имя обязательно для заполнения',
            'name.max' => 'Максимальная длинна Имя 255 символов',

            'password.min' => 'Минимальная длинна Пароля 6 символов',
            'password.max' => 'Максимальная длинна Пароля 255 символов',
            'password.required' => 'Поле Пароль обязательно для заполнения',
            'password.confirmed' => 'Пароли не совпадают',

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {


        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    public function registrarion(Request $request)
    {
        if ($request->isMethod('get')) {
            $this->addBreadCrumbls('Регистрация', route('user::registration'));
            return view('user.registration', $this->data);
        }
        if ($request->isMethod('post')) {
            /*  if(Auth::attempt(['email'=>$request->input('email'),'password'=>$request->input('password'),"is_active"=>1])){
                  return view('user.profile',$this->data);
              }
              return 0;*/
            $val = $this->validator($request->all());
            if ($val->fails()) {
                return redirect(route('user::registration'))
                    ->withErrors($val)
                    ->withInput();
            }
            $us = new User();
            $us->name = $request->input('name');
            $us->email = $request->input('email');
            $us->password = bcrypt($request->input('password'));
            $us->save();
            $this->sendEmail($us);
            return redirect(route('user::login'));
        }

        /*    $us=new User();
            $us->name="Andrey";
            $us->email='andrey@gmail.com';
            $us->password=bcrypt("passord");
            $us->save();*/
    }





    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            $this->addBreadCrumbls('Авторизация', route('user::login'));
            return view('user.login', $this->data);
        }
        if ($request->isMethod('post')) {
            if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), "is_active" => 1])) {
                return redirect(route('user::profile'));
            }
            $this->data['error'] = 'Email или пароль введен с ошибкой, повторите попытку.';
            return view('user.login', $this->data);

        }
        /*   */
    }

    public function vk($action = 'login', Request $request)
    {

        if ($request->has('access_token')) {
            return 1;
        }


        if ($request->has('code')) {
            $secretKeyApp = 'SPreQKJFieDyJxYk2JZF';
            // return $secretKeyApp;
            $idApp = '6352910';
            $code = $request->input('code');
            // $client=new Client();


            //return   redirect('https://oauth.vk.com/access_token?client_id='.$idApp.'&client_secret='.$secretKeyApp.'&redirect_uri=http://timka.by/vk&code='.$code);
            $res = file_get_contents('https://oauth.vk.com/access_token?client_id=' . $idApp . '&client_secret=' . $secretKeyApp . '&redirect_uri=http://timka.by/vk/'.$action.'&code=' . $code);


            $str = mb_convert_encoding($res, 'UTF-8');


            // return json_decode($str,true);


            $token = json_decode($str, true)['access_token'];



            $user_id = json_decode($str, true)['user_id'];
            $user = file_get_contents('https://api.vk.com/method/users.get?user_ids=' . $user_id.'&v=5.71');
              //  return json_decode($user, true);
            $user_inf = json_decode($user, true)['response'][0];


            if ($action == 'regist') {

                $email = json_decode($str, true)['email'];
                if (User::where('email', $email)->first() == null) {
                    $new = new User();
                    $new->email = $email;
                    $new->name = $user_inf['first_name'] . ' ' . $user_inf['last_name'];
                    $new->password = bcrypt($token);
                    $new->id_role = 3;
                    $new->phone = '';
                    $new->adress = '';
                    $new->feature = '';
                    $new->social = 'vk';
                    $new->social_id = $user_id;
                    $new->save();
                    $this->sendEmail($new);
                }
                $u=User::where('social_id',$user_id)->where('social','vk')->where('is_active',1)->first();
                if($u!=null){
                    Auth::login($u);
                    return redirect(route('user::profile'));
                }
                return redirect('/');
            }
            if ($action == 'login') {

                $u=User::where('social_id',$user_id)->where('social','vk')->where('is_active',1)->first();
                if($u!=null){
                    Auth::login($u);
                    return redirect(route('user::profile'));
                }
                return redirect('/');
            }
        }
    }

    public function social($social, $action = "login", Request $request)
    {
        $social_network = $social;
        switch ($social_network) {
            case 'vk':

                $filds=array();
                if($action=='regist'){

                $filds = array(
                    'notify',
                    'friends',
                    'email'
                );}
                if($action=='login'){

                    $filds = array(
                        'notify',
                        'friends'
                    );}//. '&scope=' . implode(',', $filds)
                return redirect('https://oauth.vk.com/authorize?client_id=6352910&display=page&redirect_uri=http://timka.by/vk/' . $action . '&scope=' . implode(',', $filds). '&response_type=code&v=5.71');

                // }

                break;
        }
    }



    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public  function sendEmail($user){

        Mail::send('emails.welcome',['name'=>$user->name],function ($message)use ($user){
            $message->to($user->email,'Text')->subject('Welcome!');
        });
    }
}
