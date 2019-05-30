<?php
// Namespace
namespace App\Http\Controllers\Api;
// Models
use App\Users;
// Helpers
use AuthHelper;
// Others Dependencies
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    private $users;
    private $requestData;
    private $authHelper;
    public function __construct(Users $users, AuthHelper $authHelper,  Request $request)
    {
        $this->users = $users;
        $this->authHelper = $authHelper;
        $this->requestData = $request->all();
    }
    public function get()
    {
        $request = $this->requestData;
        $statusCode = 400;
        if(isset($request['identifier']) && isset($request['key'])){
            $identifier = $request['identifier'];
            $key = $request['key'];
            $user = $this->users->where('identifier',$identifier)
                ->where('key',$key)
                ->where('auth_type','default')->first();
            if($user && !is_null($user)){
                $data['auth'] = $user->auth_hash;
                $statusCode = 200;
            }else{
                $statusCode = 404;
                $data['errors'][] = 'Usuário não encontrado.';
            }
        }else{
            $data['errors'][] = 'Por favor informe um identificador e a chave do registro.';
        }
        return response()->json(['data'=>$data],$statusCode);
    }
    public function show($auth = null)
    {
        if(is_null($auth)){
            $data['errors'][] = 'Por Favor Informe um ID.';
        }else{
            $data['user'] = $this->users->where('id',$auth)
                    ->orWhere('auth_hash',$auth)->first();
        }
        return response()->json($data,200);
    }
    public function store()
    {
        $statusCode = 404;
        $request = $this->requestData;
        $id = $this->authHelper->generateAuth($request['auth_type'],$request);
        $id = $id->id;
        $this->authHelper->insertInSession($id);
        if($id){
            $data['user'] = $this->users->find($id);
            $statusCode = 201;
        }
        return response()->json($data,$statusCode);
    }
    public function update($id)
    {
        $request = $this->requestData;
        $user = $this->users->find($id);
        $data['id'] = $id;
        $data['update'] = $user->update($request);
        return ['user'=>$data];
    }
    public function destroy($id)
    {
        $user = $this->users->find($id);
        $data['id'] = $id;
        $data['delete'] = $user->delete();
        return response()->json(['user'=>$data],200);
    }
    public function dev()
    {
        $users = $this->users->all();
        return response()->json($users,200);
    }
}
