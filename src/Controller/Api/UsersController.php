<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\Event\Event;
use Cake\Http\Exception\NotFoundException;
use Firebase\JWT\JWT;
use Cake\Utility\Security;
//tests
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
  
    public function initialize()
    {
        parent::initialize();

        $user = $this->Auth->identify();
        if ($user) {
            $this->Auth->setUser($user);
        }
        $this->Auth->allow(['add', 'token']); 
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->set('users', $this->Users->find('all'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            if($this->request->getData('role') === 'admin'){
                if($this->Auth->user('role') === 'admin'){
                    $user = $this->Users->patchEntity($user, $this->request->getData());
                    if ($this->Users->save($user)) {
                        $this->set('data', [
                            'id' => $user['id'],
                            'token' => JWT::encode(
                                [
                                    'sub' => $user['id'],
                                    'exp' =>  time() + 604800
                                ],
                            Security::getSalt())
                        ]);
                    }     
                } else {
                    $this->set('data', [
                        'message' => "You are not authorized to create an admin account!"
                    ]);
                }
            } else {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->set('data', [
                        'id' => $user['id'],
                        'token' => JWT::encode(
                            [
                                'sub' => $user['id'],
                                'exp' =>  time() + 604800
                            ],
                        Security::getSalt())
                    ]);
                }
            }
        }
        $this->set([
            'user' => $user,
            '_serialize' => ['id', 'data'],
        ]);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        return debug($this->Auth->user());
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $this->Users->save($user);
        }
        $this->set([
            'success' => true,
            'user' => $user,
            '_serialize' => ['success', 'user']
        ]);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        $this->Users->delete($user);
        $this->set([
            'success' => true,
            'user' => $user,
            '_serialize' => ['success']
        ]);
    }

    public function token()
    {
        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid username or password');
        }
        $this->set([
            'success' => true,
            'data' => [
                'id' => $user['id'],
                'token' => JWT::encode([
                    'sub' => $user['id'],
                    'exp' =>  time() + 604800
                ],
                Security::getSalt())
            ],
            '_serialize' => ['success', 'data']
        ]);
    }
}