<?php 
// In your controller, for e.g. src/Api/AppController.php

namespace App\Controller\Api;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Firebase\JWT\JWT;
use Cake\Utility\Security;

class AppController extends Controller
{
    //use \Controller\AppController;


    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler', ['enableBeforeRedirect' => false]);
        $this->loadComponent('Auth', [
            'storage' => 'Memory',
            'authorize' => ['Controller'],
            'authenticate' => [
                'Form' => [
                    //'finder' => ['Users.active' => 1]
                ],
                'ADmad/JwtAuth.Jwt' => [
                    'userModel' => 'Users',
                    'fields' => [
                        'username' => 'id'
                    ],

                    'parameter' => 'token',

                    // Boolean indicating whether the "sub" claim of JWT payload
                    // should be used to query the Users model and get user info.
                    // If set to `false` JWT's payload is directly returned.
                    'queryDatasource' => true
                ]
            ],

            'unauthorizedRedirect' => false,
            'checkAuthIn' => 'Controller.initialize',

            // If you don't have a login action in your application set
            // 'loginAction' to false to prevent getting a MissingRouteException.
            'loginAction' => false
        ]);

    }
    public function isAuthorized($user = null): bool {
		//Admin Only allowed for Admins and Super Users
		if ($this->request->getParam('prefix') === 'admin' && $user['role'] !== 'admin') {
			return false;
        } else if ( $user['role'] === 'admin' ){
            return true;
        }
		return false;
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->deny();
    }

}