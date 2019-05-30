<?php
// Namespace
namespace App\Http\Controllers\Api;
// Models
use App\Messages;
use App\Connections;
// Helpers
use AuthHelper;
use MessagesHelper;
use ConnectionsHelper;
// Others Dependencies
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    private $messages;
    private $connections;
    private $authHelper;
    private $msgHelper;
    private $connHelper;
    private $requestData;
    public function __construct(Messages $messages, Connections $connections, AuthHelper $authHelper, MessagesHelper $msgHelper, ConnectionsHelper $connHelper, Request $request)
    {
        $this->messages = $messages;
        $this->connections = $connections;
        $this->authHelper = $authHelper;
        $this->msgHelper = $msgHelper;
        $this->connHelper = $connHelper;
        $this->ip = $request->getClientIp();
        $this->requestData = $request->all();
    }
    public function index($connection = null)
    {
        $statusCode = 404;
        $request = $this->requestData;
        $data = $this->authHelper->autenticate($request);
        $errors = $data['errors'];
        $warnings = $data['warning'];
        if(count($errors)===0){
            $id = $data['id'];
            $collection = [];
            if($this->connHelper->validateConnectionsForUser($id)){
                $statusCode = 200;
                unset($data);
                if(!is_null($connection)){
                    $connections = [];
                    $connections[] = $this->connections->find($connection);
                }else{
                    $connections = $this->connections->all()->where('user_id','=',$id);
                }
                foreach ($connections as $connection){
                    $subject = $connection->subject;
                    $connectionId = $connection->connection_id;
                    $collection[$subject] = $this->messages->all()->where('connection','=',$connectionId);
                }
                $data['data'] = $collection;
            }else{
                unset($data);
                $data['errors'][] = 'Não foi possível localizar conexões estabelecidas nesse usuário';
            }
        }else{
            unset($data);
            foreach ($errors as $err){
                $data['errors'][] = $err;
            }
        }
        if(count($warnings)>0){
            foreach ($warnings as $warning){
                $data['notice'][] = $warning;
            }
        }
        return response()->json($data,$statusCode);
    }
    public function show($id)
    {
        $statusCode = 200;
        $data['data'] = $this->messages->find($id);
        if(empty($data['data'])){
            $data['errors'][] = 'Mensagem não encontrada';
            $statusCode = 404;
        }
        return response()->json($data,$statusCode);
    }
    public function store($connection = null)
    {
        $statusCode = 400;
        $request = $this->requestData;
        $data = $this->authHelper->autenticate($request,true,$this->ip);
        $errors = $data['errors'];
        $warnings = $data['warning'];
        $invalidDestination = false;
        $sessionError = false;
        if(count($errors)===0){
            $id = $data['id'];
            if(is_null($connection)){
                $users = $data['destination'];
                if (!is_array($users)) {
                    $users = [$users];
                }
                $users[] = $id;
                $connId = $this->connHelper->generateConnId($id,$users);
                if(!isset($data['subject'])){
                    $request['subject'] = $connId;
                }
                $connection = $this->connHelper->verifyPossibleInstance($connId,$id);
                if($connId &&  $connection === true){
                    $request['connection_id'] = $connId;
                    $connections = $this->connHelper->prepareData($request,$users,$id);
                    if(count($connections)>1){
                        foreach ($connections as $userKey => $request){
                            $connection = $this->connections->create($request);
                            if($userKey === $id){
                                $connection = $connection->id;
                            }
                        }
                    }else{
                        $invalidDestination = true;
                        $connection = false;
                    }
                }else{
                    if($connId == false){
                        $connection = false;
                        $sessionError = true;
                    }
                }
            }
            if($connection && $this->connHelper->validateConnectionForUser($id,$connection)){
                $connection = $this->connections->find($connection);
                $request['connection'] = $connection->connection_id;
                $request['user_id'] = $id;
                $request = $this->msgHelper->prepareData($request);
                $message = $this->messages->create($request);
                $data = ['connection' => $connection->id, 'user_id'=>$id,'message'=>$message->id];
                $data['success'] = 'Mensagem Criada com sucesso';
                $statusCode = 201;
            }elseif($invalidDestination){
                unset($data);
                $data['errors'][] = 'Não foi possível estabelecer uma conexão para algum destinatário';
                $statusCode = 404;
            }elseif($sessionError){
                unset($data);
                $data['errors'][] = 'Não foi possível estabelecer uma conexão, houve um erro de sessão';
                $statusCode = 404;
                $this->authHelper->clearSession();
            }else{
                unset($data);
                $data['errors'][] = 'Não é autorizada esta conexão para este usuário';
                $statusCode = 403;
            }
        }else{
            unset($data);
            foreach ($errors as $err){
                $data['errors'][] = $err;
            }
        }
        if(count($warnings)>0){
            foreach ($warnings as $warning){
                $data['notice'][] = $warning;
            }
        }
        return response()->json($data,$statusCode);
    }
    public function update($id)
    {
        $statusCode = 200;
        $request = $this->requestData;
        $message = $this->messages->find($id);
        if(!is_null($message)){
            $data['message'] = $id;
            $data['update'] = $message->update($request);
            $data['success'] = 'Mensagem atualizada com sucesso';
        }else{
            $data['errors'][] = 'Mensagem não encontrada';
            $statusCode = 404;
        }
        return response()->json($data,$statusCode);
    }
    public function destroy($id)
    {
        $statusCode = 200;
        $message = $this->messages->find($id);
        if($message && !is_null($message)){
            $data['message'] = $id;
            $data['delete'] = $message->delete();
            $data['success'] = 'Mensagem deletada com sucesso';
        }else{
            $data['errors'][] = 'Mensagem não encontrada';
            $statusCode = 404;
        }
        return response()->json($data,$statusCode);
    }
    public function dev()
    {
        $collection = [];
        $connections = $this->connections->all();
        foreach ($connections as $connection){
            $collection[$connection->id.'-'.$connection->subject] = $this->messages->all()->where('connection','=',$connection->connection_id);
        }
        $data = ['data' => $collection];
        return response()->json($data);
    }
}
